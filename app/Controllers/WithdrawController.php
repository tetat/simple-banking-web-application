<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\DB\SqlDb;
use App\Core\DB\FileDb;
use Database\Connection;
use App\Constants\StoragePath;
use App\Constants\Transaction;
use App\FormValidator\WithdrawForm;

class WithdrawController
{
    private $db;
    private BalanceController $balanceController;
    private TransferController $transferController;

    public function __construct($db = null)
    {
        $this->db = $db ?? Connection::create();

        if (Session::get('driver') === 'file') {
            $this->db = FileDb::create();
        } else {
            $this->db = SqlDb::create($this->db);
        }
        
        $this->balanceController = new BalanceController($this->db);
        $this->transferController = new TransferController($this->db);
    }
    
    public function create()
    {
        $user = Session::get('user', []);
        $balance = $this->balanceController->show([
            'user_id' => $user['id']
        ]);

        return view("customer/withdraw", [
            "title" => "Withdraw Balance",
            "user" => $user,
            "balance" => $balance['amount'],
            'success' => Session::get('success'),
            'errors' => Session::get('errors') ?? [],
        ]);
    }

    public function store()
    {
        $form = WithdrawForm::validate($request = [
            'amount' => $_POST['amount']
        ]);

        $amount = (float) $request['amount'];
        $user = $_SESSION['user'];

        $this->balanceController->update($form, [
            'user_id' => $user['id'],
            'amount' => -$amount
        ]);

        $transaction = [
            'sender_id' => $user['id'],
            'reciever_id' => $user['id'],
            'amount' => $amount,
            'category' => Transaction::WITHDRAW,
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

            return $id;
        }

        Session::flash('success', 'Withdraw successfull.');

        redirect(previousPage());
    }
}