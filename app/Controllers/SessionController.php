<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\DB\SqlDb;
use App\Core\DB\FileDb;
use Database\Connection;
use App\Constants\ViewPath;
use App\FormValidator\LoginForm;
use App\Controllers\UserController;

class SessionController
{
    private $db;
    private UserController $userController;

    public function __construct($db = null)
    {
        $this->db = $db ?? Connection::create();

        if (Session::get('driver') === 'file') {
            $this->db = FileDb::create(Connection::create());
        } else {
            $this->db = SqlDb::create(Connection::create($this->db));
        }

        $this->userController = new UserController($this->db);
    }
    
    public function create()
    {
        return view("login", [
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

        $user = $this->userController->show([
            'email' => $request["email"]
        ]);

        // dd($user);
        
        if ($user['email'] === $request["email"]) {
            if (! password_verify($request["password"], $user['password'])) {
                $user = [];
            }
        } else {
            $user = [];
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