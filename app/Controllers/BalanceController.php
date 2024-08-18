<?php

namespace App\Controllers;

use App\Core\Session;
use Database\Connection;
use App\Constants\StoragePath;

class BalanceController
{
    private $db;
    public function __construct($db = null)
    {
        $this->db = $db ?? Connection::create();
    }
    
    public function store(array $balance)
    {

        if (Session::get('driver') === 'file') {
            $ids = $this->db->getAll(StoragePath::PRIMARYKEYS);
            $ids['balance'] = (int) $ids['balance'] + 1;
            $balance["id"] = $ids['balance'];

            $balances = $this->db->getAll(StoragePath::BALANCES);

            $balances[] = $balance;

            $this->db->insert(StoragePath::BALANCES, $balances);
            // update primary keys
            $this->db->insert(StoragePath::PRIMARYKEYS, (array)$ids);
        } else {
            $query = "insert into balances (user_id, balance) values(:user_id, :balance)";
            $id = $this->db->insert($query, $balance);
            
            return $id;
        }
        
    }

    public function show(array $request)
    {
        $balance = [];
        
        if (Session::get('driver') === 'file') {
            $balance = $this->db->getOne(StoragePath::BALANCES, $request);
        } else {
            $query = "select * from balances where id = :id or user_id = :user_id";
            $balance = $this->db->getOne($query, $request);
        }

        return $balance;
    }

    public function update($form, array $request)
    {
        $balance = $this->db->getOne(StoragePath::BALANCES, $request);

        if ((float) $balance['amount'] + $request['amount'] < 0) {
            $form->error('balance', 'Your balance is insufficient.')->throw();
        }
        $balance['amount'] = (float) $balance['amount'] + $request['amount'];

        if (Session::get('driver') === 'file') {
            $balances = $this->db->getAll(StoragePath::BALANCES);

            foreach ($balances as $b) {
                if ($b->user_id === $request['user_id']) {
                    $b->amount = $balance['amount'];
                    break;
                }
            }

            $this->db->insert(StoragePath::BALANCES, $balances);
        } else {
            $query = "update balances SET amount = :amount where user_id = :user_id";
            unset($balance['id']);
            unset($balance['user_id']);
            $this->db->update($query, $balance);
        }
    }
}