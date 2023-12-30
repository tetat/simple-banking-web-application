<?php

namespace App\Login;

require_once __DIR__ . "/../DB/CreateConnection.php";

use App\DB\CreateConnection;

class Login {
    
    private string $email;
    private string $password;

    public function __construct(array $user) {
        
        $this->email = htmlspecialchars($user['email']);
        $this->password = $user['password'];

    }

    public function login() {

        $message = "";

        try {
            
            $connection = (new CreateConnection())->createConnection();

            $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$this->email]);

            $user = $stmt->fetch($connection::FETCH_ASSOC);

            if ($user && password_verify($this->password, $user['password'])) {
                unset($user['email']);
                unset($user['password']);
                // unset($user['role']);
                return $user;
            } else {
                $message = "Sorry, wrong credentials";
            }

        } catch (\PDOException $e) {

            $message = "Databse error: {$e->getMessage()}";

        }

        return $message;

    }

}

// $log = new Login(["email" => "n@gmail.com", "password" => "ab",]);
// print_r($log->login());