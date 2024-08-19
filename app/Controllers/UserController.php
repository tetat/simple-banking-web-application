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
        $database = $db ?? (new Connection())->create();

        if (Session::get('driver') === 'file') {
            $this->db = FileDb::create();
        }
        if (Session::get('driver') === 'mysql') {
            $this->db = SqlDb::create($database);
        }
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
        $result = [];
        if (Session::get('driver') === 'file') {
            $result = $this->db->getAll(StoragePath::USERS);
        } else {
            $query = "select * from users;";
            $result = $this->db->getAll($query);
        }

        $users = [];
        foreach($result as $u) {
            $users[] = (array) $u;
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