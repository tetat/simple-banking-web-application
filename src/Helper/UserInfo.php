<?php

namespace App\Helper;

use PDO;

class UserInfo {

    private PDO $connection;

    public function __construct(PDO $connection) {

        $this->connection = $connection;

    }

    public function getUsers() {

        $message = "";

        try {

            $stmt = $this->connection->prepare("SELECT * FROM users");
            $stmt->execute([]);

            $users = $stmt->fetchAll($this->connection::FETCH_ASSOC);

            return $users;

        } catch (\PDOException $e) {

            $message = "Database error: {$e->getMessage()}";

        }

        return $message;

    }
    
    public function getUserId(string $email) {

        $message = "";

        try {

            $stmt = $this->connection->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            $user = $stmt->fetch($this->connection::FETCH_ASSOC);

            return $user['id'];

        } catch (\PDOException $e) {

            $message = "Database error: {$e->getMessage()}";

        }

        return $message;

    }

    public function getUserName(int $user_id) {

        $message = "";

        try {

            $stmt = $this->connection->prepare("SELECT name FROM users WHERE id = ?");
            $stmt->execute([$user_id]);

            $user = $stmt->fetch($this->connection::FETCH_ASSOC);

            return $user['name'];

        } catch (\PDOException $e) {

            $message = "Database error: {$e->getMessage()}";

        }

        return $message;

    }

    public function getUserEmail(int $user_id) {

        $message = "";

        try {

            $stmt = $this->connection->prepare("SELECT email FROM users WHERE id = ?");
            $stmt->execute([$user_id]);

            $user = $stmt->fetch($this->connection::FETCH_ASSOC);

            return $user['email'];

        } catch (\PDOException $e) {

            $message = "Database error: {$e->getMessage()}";

        }

        return $message;

    }

    public function getUserBalance(int $user_id) {

        $message = "";

        try {

            $stmt = $this->connection->prepare("SELECT balance FROM users WHERE id = ?");
            $stmt->execute([$user_id]);

            $user = $stmt->fetch($this->connection::FETCH_ASSOC);

            return $user['balance'];

        } catch (\PDOException $e) {

            $message = "Database error: {$e->getMessage()}";

        }

        return $message;

    }

}
