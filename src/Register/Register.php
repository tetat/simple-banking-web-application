<?php

namespace App\Register;

require_once __DIR__ . "/../DB/CreateConnection.php";
use App\DB\CreateConnection;

class Register {

    private string $name;
    private string $email;
    private string $password;
    private string $role;
    private float $balance;

    public function __construct(array $user) {
        
        $this->name = htmlspecialchars($user['name']);
        $this->email = htmlspecialchars($user['email']);
        $this->password = password_hash($user['password'], PASSWORD_DEFAULT);
        $this->role = htmlspecialchars($user['role']);
        $this->balance = 0.0;

    }

    public function register() {

        $message = "";

        try {

            $connection = (new CreateConnection())->createConnection();
    
            $stmt = $connection->prepare("INSERT INTO users (name, email, password, role, balance) VALUES (?, ?, ?, ?, ?)");
            $result =  $stmt->execute([$this->name, $this->email, $this->password, $this->role, $this->balance]);
    
            $message = $result ? "success" : "Database error: Failed to Register";

        } catch (\PDOException $e) {

            $message = "Database error: {$e->getMessage()}";

        }

        return $message;

    }

}
