<?php

namespace Database;

use PDO;

class BalanceTable {
    
    public static function query() {
        $balanceTableSql = "CREATE TABLE IF NOT EXISTS balances (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            amount FLOAT(9,2) DEFAULT 0,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )";

        return $balanceTableSql;
    }

    public static function create(PDO $db)
    {
        $stmt = $db->prepare(self::query());
        $result = $stmt->execute();

        return $result;
    }

}