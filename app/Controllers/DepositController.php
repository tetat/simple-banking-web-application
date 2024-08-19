<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\DB\SqlDb;
use App\Core\DB\FileDb;
use Database\Connection;
use App\Constants\StoragePath;
use App\Constants\Transaction;
use App\FormValidator\DepositForm;

class DepositController
{
    private $db;
    private BalanceController $balanceController;
    private TransferController $transferController;

    public function __construct($db = null)
    {
        $database = $db ?? (new Connection())->create();

        if (Session::get('driver') === 'file') {
            $this->db = FileDb::create();
        }
        if (Session::get('driver') === 'mysql') {
            $this->db = SqlDb::create($database);
        }
        
        $this->balanceController = new BalanceController($database);
        $this->transferController = new TransferController($database);
    }
    
    public function create()
    {
        $user = Session::get('user', []);
        $balance = $this->balanceController->show([
            'id' => 0,
            'user_id' => $user['id']
        ]);
        
        return view("customer/deposit", [
            "title" => "Deposit Balance",
            "user" => $user,
            "balance" => $balance['amount'],
            'success' => Session::get('success'),
            'errors' => Session::get('errors') ?? [],
        ]);
    }

    public function store()
    {
        $form = DepositForm::validate($request = [
            'amount' => $_POST['amount']
        ]);

        $amount = (float) $request['amount'];
        $user = Session::get('user', []);
        $this->balanceController->update($form, [
            'user_id' => $user['id'],
            'amount' => $amount
        ]);
        
        $transaction = [
            'sender_id' => $user['id'],
            'reciever_id' => $user['id'],
            'amount' => $amount,
            'category' => Transaction::DEPOSIT,
            'created_at' => date("Y-m-d h:i:sa")
        ];

        if (Session::get('driver') === 'file') {
            $ids = $this->db->getAll(StoragePath::PRIMARYKEYS);
            $ids['transaction'] = (int) $ids['transaction'] + 1;
            $transaction["id"] = $ids['transaction'];

            $transactions = $this->transferController->index();
            $transactions[] = $transaction;

            $this->db->insert(StoragePath::TRANSACTIONS, $transactions);
            // update primary keys
            $this->db->insert(StoragePath::PRIMARYKEYS, (array)$ids);
        } else {
            unset($transaction['created_at']);
            $query = "insert into transactions (sender_id, reciever_id, amount, category) values(:sender_id, :reciever_id, :amount, :category)";
            $id = $this->db->insert($query, $transaction);
        }

        Session::flash('success', 'Deposit successfull.');

        redirect(previousPage());
    }
}