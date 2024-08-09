<?php

namespace App\Controllers;

use App\Core\Session;
use App\Constants\UserRole;

class AdminController
{
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

        view("admin/customers", [
            'title' => "All Customers",
            'admin' => $_SESSION['user'],
            'users' => $users,
        ]);
    }

    public function allTransactions()
    {
        $transactions = (new TransferController())->index();

        view("admin/transactions", [
            'title' => "Transactions",
            'admin' => $_SESSION['user'],
            'transactions' => $transactions,
        ]);
    }

    public function userTransactions()
    {
        // dd($_GET);
        $user = (new UserController())->show($_GET['handle']);
        $transactions = (new TransferController())->show($user->email);

        view("admin/customer_transactions", [
            'title' => "Transactions of {$user->name}",
            'admin' => $_SESSION['user'],
            'user' => $user,
            'transactions' => $transactions,
        ]);
    }
}