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
        $this->db = $db ?? Connection::create();

        if (Session::get('driver') === 'file') {
            $this->db = FileDb::create();
        } else {
            $this->db = SqlDb::create($this->db);
        }

        $this->balanceController = new BalanceController($this->db);
        $this->transferController = new TransferController($this->db);
    }

    public function dashboard()
    {
        $user = Session::get('user');
        $balance = $this->balanceController->show([
            'user_id' => $user['id']
        ]);
        $transactions = $this->transferController->show([
            'id' => $user['id']
        ]);
        // dd($transactions);
        return view("customer/dashboard", [
            "title" => "Dashboard",
            "user" => $user,
            "balance" => $balance['amount'],
            "transactions" => $transactions,
            'errors' => Session::get('errors')
        ]);
    }
}