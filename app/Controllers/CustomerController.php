<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\DB\SqlDb;
use App\Core\DB\FileDb;
use Database\Connection;

class CustomerController
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

    public function dashboard()
    {
        $user = Session::get('user');
        $balance = $this->balanceController->show([
            'id' => 0,
            'user_id' => $user['id']
        ]);
        $transactions = $this->transferController->show([
            'sender_id' => $user['id'],
            'reciever_id' => $user['id']
        ]);
        
        return view("customer/dashboard", [
            "title" => "Dashboard",
            "user" => $user,
            "balance" => $balance['amount'],
            "transactions" => $transactions,
            'errors' => Session::get('errors', [])
        ]);
    }
}