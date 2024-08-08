<?php

namespace App\Controllers;

use App\Controllers\UserController;
use App\Controllers\BalanceController;

class CustomerController
{
    private BalanceController $balanceController;

    public function __construct()
    {
        $this->balanceController = new BalanceController();
    }

    public function dashboard()
    {
        $userHandle = $_SESSION["user"]->handle;
        $user = $_SESSION["user"];
        $balance = $this->balanceController->show($userHandle);

        view("customer/dashboard", [
            "title" => "Dashboard",
            "user" => $user,
            "balance" => $balance
        ]);
    }
}