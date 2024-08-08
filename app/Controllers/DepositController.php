<?php

namespace App\Controllers;

use App\Controllers\BalanceController;

class DepositController
{
    private BalanceController $balanceController;

    public function __construct()
    {
        $this->balanceController = new BalanceController();
    }
    
    public function create()
    {
        $userHandle = $_SESSION["user"]->handle;
        $user = $_SESSION["user"];
        $balance = $this->balanceController->show($userHandle);

        return view("customer/deposit", [
            "title" => "Deposit Balance",
            "user" => $user,
            "balance" => $balance
        ]);
    }

    public function store()
    {
        $handle = $_SESSION['user']->handle;


    }
}