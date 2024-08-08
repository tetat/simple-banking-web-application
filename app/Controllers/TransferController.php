<?php

namespace App\Controllers;

use App\Core\Session;
use App\Controllers\BalanceController;
use App\FormValidator\TransferForm;

class TransferController
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

        return view("customer/transfer", [
            "title" => "Transfer Balance",
            "user" => $user,
            "balance" => $balance['amount'],
            'success' => Session::get('success'),
            'errors' => Session::get('errors') ?? [],
        ]);
    }

    public function store()
    {
        $form = TransferForm::validate($request = [
            'email' => $_POST['email'],
            'amount' => $_POST['amount']
        ]);

        $sender_handle = $_SESSION['user']->handle;
        $amount = (float) $request['amount'];
        $this->balanceController->update($form, $sender_handle, -$amount);
        
        $reciever_handle = explode('@', $request["email"])[0];
        $this->balanceController->update($form, $reciever_handle, $amount);

        Session::flash('success', 'Transaction successfull.');

        redirect(previousPage());
    }
}