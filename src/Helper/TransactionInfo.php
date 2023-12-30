<?php

namespace App\Helper;

use PDO;

class TransactionInfo {

    private PDO $connection;

    public function __construct(PDO $connection) {

        $this->connection = $connection;

    }

    public function getUserTransfers(int $user_id) {

        $message = "";

        try {

            $stmt = $this->connection->prepare("SELECT * FROM moneytransfer WHERE user_id = ?");
            $stmt->execute([$user_id]);

            $transfers = $stmt->fetchAll($this->connection::FETCH_ASSOC);

            return $transfers;

        } catch (\PDOException $e) {

            $message = "Database error: {$e->getMessage()}";

        }

        return $message;

    }

    public function getAllTransactions() {

        $message = "";

        try {

            $stmt = $this->connection->prepare("SELECT * FROM transactions");
            $stmt->execute();

            $transactions = $stmt->fetchAll($this->connection::FETCH_ASSOC);

            return $transactions;

        } catch (\PDOException $e) {

            $message = "Database error: {$e->getMessage()}";

        }

        return $message;

    }

}