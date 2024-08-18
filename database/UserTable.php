<?php

namespace Database;

use PDO;


class UserTable {
    
    public static function query() {
        $userTableSql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            password VARCHAR(255),
            role VARCHAR(10) DEFAULT 'customer'
        )";

        return $userTableSql;
    }

    public static function create(PDO $db)
    {
        $stmt = $db->prepare(self::query());
        $result = $stmt->execute();

        return $result;
    }
}