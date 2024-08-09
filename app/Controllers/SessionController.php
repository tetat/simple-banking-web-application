<?php

namespace App\Controllers;

use App\Constants\UserRole;
use App\Core\Session;
use App\Constants\ViewPath;
use App\Controllers\UserController;
use App\FormValidator\LoginForm;

class SessionController
{
    private UserController $userController;

    public function __construct()
    {
        $this->userController = new UserController();
    }
    
    public function create()
    {
        view("login", [
            'title' => "Login - Bangubank",
            'errors' => Session::get('errors'),
            'success' => Session::get('success')
        ]);
    }

    public function store()
    {
        $form = LoginForm::validate($request = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ]);

        $handle = explode('@', $request["email"])[0];
        $request["handle"] = $handle;

        $user = $this->userController->show($handle);
        
        if ($user->handle === $request["handle"]) {
            if (! password_verify($request["password"], $user->password)) {
                $user = [];
            }
        }

        if (!$user) {
            $form->error(
                'auth', 'Email or password is incorrect.'
            )->throw();
        }

        Session::put('user', $user);
        redirect(ViewPath::HOME);
    }

    public function destroy()
    {        
        Session::destroy();
        
        redirect(ViewPath::HOME);
    }
}