<?php

namespace Database;

use PDO;


class TransactionTable {
    
    public static function query() {
        $transactionTableSql = "CREATE TABLE IF NOT EXISTS transactions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sender_id INT,
            reciever_id INT,
            amount FLOAT(9,2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender_id) REFERENCES users(id),
            FOREIGN KEY (reciever_id) REFERENCES users(id)
        )";
        
        return $transactionTableSql;
    }

    public static function create(PDO $db)
    {
        $stmt = $db->prepare(self::query());
        $result = $stmt->execute();

        return $result;
    }
}