<?php

namespace App\Controllers;

use App\Core\Session;
use App\Constants\StoragePath;
use App\Constants\UserRole;
use App\FormValidator\TransferForm;

class TransferController
{
    private UserController $userController;
    private BalanceController $balanceController;

    public function __construct()
    {
        $this->userController = new UserController();
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

        $amount = (float) $request['amount'];
        $sender = $_SESSION['user'];
        $reciever = $this->userController->show(explode('@', $request["email"])[0]);

        if (!$reciever) {
            $form->error('404', 'Reciever not found.')->throw();
        }
        if ($request["email"] !== $reciever->email) {
            $form->error('404', 'Reciever not found.')->throw();
        }
        if ($reciever->role === UserRole::ADMIN) {
            $form->error('auth', 'You can not give money to an admin.')->throw();
        }
        if ($sender->email === $reciever->email ?? '') {
            $form->error('self', 'Self transaction is not valid.')->throw();
        }

        $this->balanceController->update($form, $sender->handle, -$amount);
        $this->balanceController->update($form, $reciever->handle, $amount);

        $transactions = $this->index();
        
        $transactions[] = [
            'sender' => [
                'name' => $sender->name,
                'email' => $sender->email,
            ],
            'reciever' => [
                'name' => $reciever->name,
                'email' => $reciever->email,
            ],
            'amount' => $amount,
            'time' => date("Y-m-d h:i:sa")
        ];

        $jsonData = json_encode($transactions, JSON_PRETTY_PRINT);
        file_put_contents(StoragePath::TRANSACTIONS, $jsonData);

        Session::flash('success', 'Transaction successfull.');

        redirect(previousPage());
    }

    public function index()
    {
        $transactions = json_decode(
            file_get_contents(StoragePath::TRANSACTIONS, true)
        );

        return $transactions ?? [];
    }

    public function show(string $email)
    {
        $transactions = $this->index();

        $transactions = array_filter($transactions, function ($transaction) use($email){
            return $email === $transaction->sender->email or $email === $transaction->reciever->email;
        });

        return $transactions ?? [];
    }
}