<?php

namespace App\Controllers;

use Database\Connection;
use App\Core\Session;
use App\Core\DB\SqlDb;
use App\Core\DB\FileDb;
use App\Constants\UserRole;
use App\Constants\ViewPath;
use App\Constants\StoragePath;
use App\Controllers\UserController;
use App\FormValidator\RegisterForm;
use App\Controllers\BalanceController;

class RegisterController
{
    private $db;
    private UserController $userController;
    private BalanceController $balanceController;

    public function __construct($db = null)
    {
        $database = $db ?? (new Connection())->create();

        if (Session::get('driver') === 'file') {
            $this->db = FileDb::create();
        }
        if (Session::get('driver') === 'mysql') {
            $this->db = SqlDb::create($database);
        }

        $this->userController = new UserController($database);
        $this->balanceController = new BalanceController($database);
    }

    public function create()
    {
        return view("register", [
            'title' => "Register - Bangubank",
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
        
        if ($this->userController->show([
            'id' => 0,
            'email' => $request["email"]
            ])) {
            $form->error('auth', 'User already exist.')->throw();
        }

        $request["password"] = password_hash($request["password"], PASSWORD_DEFAULT);
        unset($request["password2"]);

        $request["role"] = UserRole::CUSTOMER;

        if (Session::get('driver') === 'file') {
            $ids = $this->db->getAll(StoragePath::PRIMARYKEYS);

            $ids['user'] = (int) $ids['user'] + 1;
            $ids['balance'] = (int) $ids['balance'] + 1;
            $request["id"] = $ids['user'];

            $this->userController->store($request);
            
            $this->balanceController->store([
                "id" => $ids['balance'],
                "user_id" => $ids['user'],
                "amount" => 0
            ]);
            // update primary keys
            $this->db->insert(StoragePath::PRIMARYKEYS, (array)$ids);
        } else {
            try {
                $id = $this->userController->store($request);
                
                $this->balanceController->store([
                    "user_id" => $id
                ]);
            } catch (\Exception $e) {
                $form->error('500', 'Internal server error.')->throw();
            }
            
        }

        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] === UserRole::ADMIN) {
                Session::flash('success', 'Customer has been added successfully.');
                redirect(previousPage());
            }
        }

        Session::flash('success', 'Your account has been created. Please login!');
        redirect(ViewPath::LOGIN);
    }
}