<?php

namespace App\Controllers;

use App\Core\Session;
use App\Constants\StoragePath;
use App\FormValidator\DepositForm;

class DepositController
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
        $balance = $this->balanceController->show($userHandle);

        return view("customer/deposit", [
            "title" => "Deposit Balance",
            "user" => $_SESSION["user"],
            "balance" => $balance['amount'],
            'success' => Session::get('success'),
            'errors' => Session::get('errors') ?? [],
        ]);
    }

    public function store()
    {
        $form = DepositForm::validate($request = [
            'amount' => $_POST['amount']
        ]);

        $amount = (float) $request['amount'];
        $user = $_SESSION['user'];

        $this->balanceController->update($form, $user->handle, $amount);

        $transactions = $this->transferController->index();
        
        $transactions[] = [
            'sender' => [
                'name' => 'Self',
                'email' => 'Deposit',
            ],
            'reciever' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'amount' => $amount,
            'time' => date("Y-m-d h:i:sa")
        ];

        $jsonData = json_encode($transactions, JSON_PRETTY_PRINT);
        file_put_contents(StoragePath::TRANSACTIONS, $jsonData);

        Session::flash('success', 'Deposit successfull.');

        redirect(previousPage());
    }
}