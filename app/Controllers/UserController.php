<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\DB\SqlDb;
use App\Core\DB\FileDb;
use Database\Connection;
use App\Constants\StoragePath;

class UserController
{
    private $db;

    public function __construct($db = null)
    {
        $this->db = $db ?? Connection::create();

        // if (Session::get('driver') === 'file') {
        //     $this->db = FileDb::create(Connection::create());
        // } else {
        //     $this->db = SqlDb::create(Connection::create($this->db));
        // }
    }

    public function store(array $user)
    {
        if (Session::get('driver') === 'file') {
            $users = $this->index();
            $users[] = $user;
    
            $this->db->insert(StoragePath::USERS, $users);
        } else {
            $query = "insert into users (name, email, password, role) values(:name, :email, :password, :role)";
            $id = $this->db->insert($query, $user);
            
            return $id;
        }
    }

    public function index()
    {
        $users = [];
        if (Session::get('driver') === 'file') {
            $users = $this->db->getAll(StoragePath::USERS);
        } else {
            $query = "select * from users;";
            $users = $this->db->getAll($query);
        }

        return $users;
    }

    public function show(array $request)
    {
        $user = [];
        if (Session::get('driver') === 'file') {
            $user = $this->db->getOne(StoragePath::USERS, $request);
        } else {
            $query = "select * from users where id = :id or email = :email";
            $user = $this->db->getOne($query, $request);
        }
        
        return $user;
    }
}