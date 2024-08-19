<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\DB\SqlDb;
use App\Core\DB\FileDb;
use Database\Connection;
use App\Constants\UserRole;
use App\Constants\StoragePath;

class AdminController
{
    private $db;
    private UserController $userController;
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
        $this->userController = new UserController($database);
        $this->transferController = new TransferController($database);
        
    }
    
    public function customers()
    {
        $users = $this->userController->index();
        
        $users = array_filter($users, function($u) {
            return $u['role'] === UserRole::CUSTOMER;
        });
        
        return view("admin/customers", [
            'title' => "All Customers",
            'admin' => Session::get('user', []),
            'users' => $users,
            'errors' => Session::get('errors', [])
        ]);
    }

    public function allTransactions()
    {
        $transactions = $this->transferController->index();
        
        return view("admin/transactions", [
            'title' => "Transactions",
            'admin' => Session::get('user', []),
            'transactions' => $transactions,
        ]);
    }

    public function userTransactions()
    {
        $user = $this->userController->show([
            'id' => $_GET['id'],
            'email' => 'dummy@gmail.com'
        ]);
        
        $transactions = $this->transferController->show([
            'sender_id' => $_GET['id'],
            'reciever_id' => $_GET['id']
        ]);
        
        return view("admin/customer_transactions", [
            'title' => "Transactions of {$user['name']}",
            'admin' => Session::get('user', []),
            'user' => $user,
            'transactions' => $transactions,
        ]);
    }

    public function createCustomer()
    {
        return view('admin/add_customer', [
            'title' => 'Add Customer',
            'admin' => Session::get('user', []),
            'success' => Session::get('success', []),
            'errors' => Session::get('errors', [])
        ]);
    }

    // this method for admin register with CLI
    public function store(array $admin): bool
    {        
        $admin['password'] = password_hash($admin["password"], PASSWORD_DEFAULT);
        $admin['role'] = UserRole::ADMIN;

        // if user already exist
        if ($this->userController->show([
            'id' => 0,
            'email' => $admin['email']
        ])) {
            return false;
        }

        if (Session::get('driver') === 'file') {
            $ids = $this->db->getAll(StoragePath::PRIMARYKEYS);

            $ids['user'] = (int) $ids['user'] + 1;
            $admin["id"] = $ids['user'];

            $this->userController->store($admin);
            // update primary keys
            $this->db->insert(StoragePath::PRIMARYKEYS, (array)$ids);
        } else {
            $this->userController->store($admin);
        }
        
        return true;
    }
}