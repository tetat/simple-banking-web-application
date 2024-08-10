<?php

namespace App\Controllers;

use App\Core\Session;
use App\Constants\UserRole;
use App\Constants\StoragePath;

class AdminController
{
    // this method for admin register with CLI
    public function store(array $admin): bool
    {        
        $admin['password'] = password_hash($admin["password"], PASSWORD_DEFAULT);
        $admin['role'] = UserRole::ADMIN;

        // if user already exist
        if ((new UserController())->show($admin['handle'])) {
            return false;
        }

        $users = (new UserController())->index();
        $users[] = $admin;
    
        $jsonData = json_encode($users, JSON_PRETTY_PRINT);
        file_put_contents(StoragePath::USERS, $jsonData);
        
        return true;
    }

    public function createCustomer()
    {
        return view('admin/add_customer', [
            'title' => 'Add Customer',
            'admin' => $_SESSION['user'],
            'success' => Session::get('success'),
            'errors' => Session::get('errors')
        ]);
    }

    public function customers()
    {
        $users = (new UserController())->index();

        $users = array_filter($users, function($u) {
            return $u->role === UserRole::CUSTOMER;
        });

        return view("admin/customers", [
            'title' => "All Customers",
            'admin' => $_SESSION['user'],
            'users' => $users,
            'errors' => Session::get('errors')
        ]);
    }

    public function allTransactions()
    {
        $transactions = (new TransferController())->index();

        return view("admin/transactions", [
            'title' => "Transactions",
            'admin' => $_SESSION['user'],
            'transactions' => $transactions,
        ]);
    }

    public function userTransactions()
    {
        $user = (new UserController())->show($_GET['handle']);
        $transactions = (new TransferController())->show($user->email);

        return view("admin/customer_transactions", [
            'title' => "Transactions of {$user->name}",
            'admin' => $_SESSION['user'],
            'user' => $user,
            'transactions' => $transactions,
        ]);
    }
}