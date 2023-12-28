<?php

namespace App\Helper;

use PDO;

class UserInfo {

    private PDO $connection;

    public function __construct(PDO $connection) {

        $this->connection = $connection;

    }
    
    public function getUserId(string $email) {

        $message = "";

        try {

            $stmt = $this->connection->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            $user = $stmt->fetch($this->connection::FETCH_ASSOC);

            return $user['id'];

        } catch (\PDOException $e) {

            $message = "Databse error: {$e->getMessage()}";

        }

        return $message;

    }

    public function getUserBalance(int $user_id) {

        $message = "";

        try {

            $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$user_id]);

            $user = $stmt->fetch($this->connection::FETCH_ASSOC);

            return $user['balance'];

        } catch (\PDOException $e) {

            $message = "Databse error: {$e->getMessage()}";

        }

        return $message;

    }

}