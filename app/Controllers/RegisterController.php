<?php

namespace App\Controllers;

use App\Core\Session;
use App\Constants\UserRole;
use App\Constants\ViewPath;
use App\Constants\StoragePath;
use App\Controllers\UserController;
use App\FormValidator\RegisterForm;
use App\Controllers\BalanceController;

class RegisterController
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
        view("register", [
            'errors' => Session::get('errors')
        ]);
    }

    public function store()
    {
        $form = RegisterForm::validate($request = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'password2' => $_POST['password2'],
        ]);


        $handle = explode('@', $request["email"])[0];
        $request["handle"] = $handle;
        // if user already exist
        if ($this->userController->show($handle)) {
            $form->error('auth', 'User already exist.')->throw();
        }

        $request["password"] = password_hash($request["password"], PASSWORD_DEFAULT);
        unset($request["password2"]);

        $request["role"] = UserRole::CUSTOMER;
        
        $users = $this->userController->index();
        $users[] = $request;

        $jsonData = json_encode($users, JSON_PRETTY_PRINT);
        file_put_contents(StoragePath::USERS, $jsonData);

        $this->balanceController->store([
            "handle" => $handle,
            "balance" => 0
        ]);

        Session::flash('success', 'Your account has been created. Please login!');
        redirect(ViewPath::LOGIN);
    }
}