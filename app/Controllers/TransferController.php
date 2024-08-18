<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\DB\SqlDb;
use App\Core\DB\FileDb;
use Database\Connection;
use App\Constants\UserRole;
use App\Constants\StoragePath;
use App\Constants\Transaction;
use App\FormValidator\TransferForm;

class TransferController
{
    private $db;
    private UserController $userController;
    private BalanceController $balanceController;

    public function __construct($db = null)
    {
        $this->db = $db ?? Connection::create();

        if (Session::get('driver') === 'file') {
            $this->db = FileDb::create();
        } else {
            $this->db = SqlDb::create($this->db);
        }
        
        $this->userController = new UserController($this->db);
        $this->balanceController = new BalanceController($this->db);
    }
    
    public function create()
    {
        $user = Session::get('user', []);
        $balance = $this->balanceController->show([
            'user_id' => $user['id']
        ]);

        return view("customer/transfer", [
            "title" => "Transfer Balance",
            "user" => $user,
            "balance" => $balance['amount'],
            'success' => Session::get('success', []),
            'errors' => Session::get('errors', []),
        ]);
    }

    public function store()
    {
        $form = TransferForm::validate($request = [
            'email' => $_POST['email'],
            'amount' => $_POST['amount']
        ]);

        $amount = (float) $request['amount'];
        $sender = Session::get('user', []);
        $reciever = $this->userController->show(['email' => $request["email"]]);

        if (!$reciever) {
            $form->error('404', 'Reciever not found.')->throw();
        }
        if ($reciever['role'] === UserRole::ADMIN) {
            $form->error('auth', 'You can not give money to an admin.')->throw();
        }
        if ($sender['email'] === $reciever['email']) {
            $form->error('403', 'Self transaction is forbidden.')->throw();
        }

        $this->balanceController->update($form, [
            'user_id' => $sender['id'],
            'amount' => -$amount
        ]);
        $this->balanceController->update($form, [
            'user_id' => $reciever['id'],
            'amount' => $amount
        ]);

        $transaction = [
            'sender_id' => $sender['id'],
            'reciever_id' => $reciever['id'],
            'amount' => $amount,
            'category' => Transaction::TRANSFER,
            'created_at' => date("Y-m-d h:i:sa")
        ];

        if (Session::get('driver') === 'file') {
            $ids = $this->db->getAll(StoragePath::PRIMARYKEYS);
            $ids['transaction'] = (int) $ids['transaction'] + 1;
            $transaction["id"] = $ids['transaction'];

            $transactions = $this->index();
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

        Session::flash('success', 'Transaction successfull.');

        redirect(previousPage());
    }

    public function index()
    {
        $users = [];
        if (Session::get('driver') === 'file') {
            $users = $this->db->getAll(StoragePath::TRANSACTIONS);
        } else {
            $query = "select * from transactionsinner join users on transactions.sender_id = users.id or transactions.reciever_id = users.id";
            $users = $this->db->getAll($query);
        }

        return $users;
    }

    public function show(array $request)
    {
        $transactions = [];
        if (Session::get('driver') === 'file') {
            $transactions = $this->index();

            $transactions = array_filter($transactions, function ($transaction) use($request){
                if ($request['id'] === $transaction->sender_id or $request['id'] === $transaction->reciever_id) {
                    $transaction->user = $this->userController->show(['id' => $request["id"]]);
                    return true;
                }
            });
        } else {
            $query = "select * from transactions where sender_id = :id or reciever_id = :id inner join users on transactions.sender_id = users.id or transactions.reciever_id = users.id";
            $transactions = $this->db->getOne($query, $request);
        }
        
        return $transactions;
    }
}