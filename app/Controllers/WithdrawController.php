<?php

namespace App\Controllers;

use App\Core\Session;
use App\Constants\StoragePath;
use App\FormValidator\WithdrawForm;

class WithdrawController
{
    private BalanceController $balanceController;
    private TransferController $transferController;

    public function __construct()
    {
        $this->balanceController = new BalanceController();
        $this->transferController = new TransferController();
    }
    
    public function create()
    {
        $userHandle = $_SESSION["user"]->handle;
        $user = $_SESSION["user"];
        $balance = $this->balanceController->show($userHandle);

        return view("customer/withdraw", [
            "title" => "Withdraw Balance",
            "user" => $user,
            "balance" => $balance['amount'],
            'success' => Session::get('success'),
            'errors' => Session::get('errors') ?? [],
        ]);
    }

    public function store()
    {
        $form = WithdrawForm::validate($request = [
            'amount' => $_POST['amount']
        ]);

        $amount = (float) $request['amount'];
        $user = $_SESSION['user'];

        $this->balanceController->update($form, $user->handle, -$amount);

        $transactions = $this->transferController->index();
        
        $transactions[] = [
            'sender' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'reciever' => [
                'name' => 'Self',
                'email' => 'Withdraw',
            ],
            'amount' => $amount,
            'time' => date("Y-m-d h:i:sa")
        ];

        $jsonData = json_encode($transactions, JSON_PRETTY_PRINT);
        file_put_contents(StoragePath::TRANSACTIONS, $jsonData);

        Session::flash('success', 'Withdraw successfull.');

        redirect(previousPage());
    }
}