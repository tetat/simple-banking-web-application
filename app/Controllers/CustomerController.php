<?php

namespace App\Controllers;

// use App\Controllers\BalanceController;

class CustomerController
{
    private BalanceController $balanceController;
    private TransferController $transferController;

    public function __construct()
    {
        $this->balanceController = new BalanceController();
        $this->transferController = new TransferController();
    }

    public function dashboard()
    {
        $userHandle = $_SESSION["user"]->handle;
        $user = $_SESSION["user"];
        $balance = $this->balanceController->show($userHandle);
        $transactions = $this->transferController->show($user->email);

        return view("customer/dashboard", [
            "title" => "Dashboard",
            "user" => $user,
            "balance" => $balance['amount'],
            "transactions" => $transactions
        ]);
    }
}