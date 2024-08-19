<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\DB\SqlDb;
use App\Core\DB\FileDb;
use Database\Connection;
use App\Constants\UserRole;
use App\Constants\StoragePath;
use App\Constants\Transaction;
use App\FormValidator\TransferForm;

class TransferController
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
        $user = Session::get('user', []);
        $balance = $this->balanceController->show([
            'id' => 0,
            'user_id' => $user['id']
        ]);

        return view("customer/transfer", [
            "title" => "Transfer Balance",
            "user" => $user,
            "balance" => $balance['amount'],
            'success' => Session::get('success', []),
            'errors' => Session::get('errors', []),
        ]);
    }

    public function store()
    {
        $form = TransferForm::validate($request = [
            'email' => $_POST['email'],
            'amount' => $_POST['amount']
        ]);

        $amount = (float) $request['amount'];
        $sender = Session::get('user', []);
        $reciever = $this->userController->show([
            'id' => 0, // we have to provide an id for query. there is no user that contains id 0 but email will find that user.
            'email' => $request["email"]
        ]);

        if (!$reciever) {
            $form->error('404', 'Reciever not found.')->throw();
        }
        if ($reciever['role'] === UserRole::ADMIN) {
            $form->error('auth', 'You can not give money to an admin.')->throw();
        }
        if ($sender['email'] === $reciever['email']) {
            $form->error('403', 'Self transaction is forbidden.')->throw();
        }

        $this->balanceController->update($form, [
            'user_id' => $sender['id'],
            'amount' => -$amount
        ]);
        $this->balanceController->update($form, [
            'user_id' => $reciever['id'],
            'amount' => $amount
        ]);

        $transaction = [
            'sender_id' => $sender['id'],
            'reciever_id' => $reciever['id'],
            'amount' => $amount,
            'category' => Transaction::TRANSFER,
            'created_at' => date("Y-m-d h:i:sa")
        ];

        if (Session::get('driver') === 'file') {
            $ids = $this->db->getAll(StoragePath::PRIMARYKEYS);
            $ids['transaction'] = (int) $ids['transaction'] + 1;
            $transaction["id"] = $ids['transaction'];

            $transactions = [];
            $result = $this->index();
            foreach($result as $t) {
                unset($t['sender_name']);
                unset($t['sender_email']);
                unset($t['reciever_name']);
                unset($t['reciever_email']);
                $transactions[] = $t;
            }
            $transactions[] = $transaction;

            $this->db->insert(StoragePath::TRANSACTIONS, $transactions);
            // update primary keys
            $this->db->insert(StoragePath::PRIMARYKEYS, (array)$ids);
        } else {
            unset($transaction['created_at']);
            $query = "insert into transactions (sender_id, reciever_id, amount, category) values(:sender_id, :reciever_id, :amount, :category)";
            $id = $this->db->insert($query, $transaction);
        }

        Session::flash('success', 'Transaction successfull.');

        redirect(previousPage());
    }

    public function index()
    {
        $transactions = [];
        if (Session::get('driver') === 'file') {
            $result = $this->db->getAll(StoragePath::TRANSACTIONS);
            foreach ($result as $t) {
                $t = (array) $t;
                $sender = $this->userController->show(['id' => $t["sender_id"]]);
                $reciever = $this->userController->show(['id' => $t["reciever_id"]]);
                
                $t['sender_name'] = $sender['name'];
                $t['sender_email'] = $sender['email'];
                $t['reciever_name'] = $reciever['name'];
                $t['reciever_email'] = $reciever['email'];
                
                $transactions[] = $t;
            }
        } else {
            $query = "select transactions.id as id, transactions.amount as amount, transactions.category as category, transactions.created_at as created_at, transactions.sender_id as sender_id, transactions.reciever_id as reciever_id from transactions inner join users on transactions.sender_id = users.id or transactions.reciever_id = users.id";
            
            $result = $this->db->getAll($query);
            
            foreach($result as $t) {
                $query = "select users.name as sender_name, users.email as sender_email from users where id = :sender_id";
                $sender = $this->db->getOne($query, ['sender_id' => $t['sender_id']]);
                $query = "select users.name as reciever_name, users.email as reciever_email from users where id = :reciever_id";
                $reciever = $this->db->getOne($query, ['reciever_id' => $t['reciever_id']]);
                
                $t['sender_name'] = $sender['sender_name'];
                $t['sender_email'] = $sender['sender_email'];
                $t['reciever_name'] = $reciever['reciever_name'];
                $t['reciever_email'] = $reciever['reciever_email'];

                $transactions[] = $t;
            }
        }

        return $transactions;
    }

    public function show(array $request)
    {
        $transactions = [];
        if (Session::get('driver') === 'file') {
            $transactionsData = $this->index();
            
            foreach($transactionsData as $t) {
                $sender = [];
                $reciever = [];
                if ($request['sender_id'] == $t['sender_id']) {
                    $sender = $this->userController->show(['id' => $t["sender_id"]]);
                    $reciever = $this->userController->show(['id' => $t["reciever_id"]]);
                }
                if ($request['reciever_id'] == $t['reciever_id']) {
                    $sender = $this->userController->show(['id' => $t["sender_id"]]);
                    $reciever = $this->userController->show(['id' => $t["reciever_id"]]);
                }
        
                if ($sender and $reciever) {
                    $transaction = [
                        'id' => $t['id'],
                        'sender_id' => $t['sender_id'],
                        'reciever_id' => $t['reciever_id'],
                        'amount' => $t['amount'],
                        'category' => $t['category'],
                        'created_at' => $t['created_at'],
                        'sender_name' => $sender['name'],
                        'sender_email' => $sender['email'],
                        'reciever_name' => $reciever['name'],
                        'reciever_email' => $reciever['email'],
                    ];
    
                    $transactions[] = $transaction;
                }

            }
        } else {
            $query = "select transactions.id as id, transactions.amount as amount, transactions.category as category, transactions.created_at as created_at, transactions.sender_id as sender_id, transactions.reciever_id as reciever_id from transactions inner join users on transactions.sender_id = users.id or transactions.reciever_id = users.id where transactions.sender_id = :sender_id or transactions.reciever_id = :reciever_id";
            
            $result = $this->db->getMany($query, $request);
            
            foreach($result as $t) {
                $query = "select users.name as sender_name, users.email as sender_email from users where id = :sender_id";
                $sender = $this->db->getOne($query, ['sender_id' => $t['sender_id']]);
                $query = "select users.name as reciever_name, users.email as reciever_email from users where id = :reciever_id";
                $reciever = $this->db->getOne($query, ['reciever_id' => $t['reciever_id']]);
                
                $t['sender_name'] = $sender['sender_name'];
                $t['sender_email'] = $sender['sender_email'];
                $t['reciever_name'] = $reciever['reciever_name'];
                $t['reciever_email'] = $reciever['reciever_email'];

                $transactions[] = $t;
            }
        }
        
        return $transactions ?? [];
    }
}