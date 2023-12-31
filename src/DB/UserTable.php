<?php

namespace App\DB;

require __DIR__ . "/CreateTable.php";

class UserTable {

    use CreateTable;
    
    public function createUserTable() {
        $userTableSql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            email VARCHAR(100) UNIQUE,
            password VARCHAR(100),
            role VARCHAR(100),
            balance FLOAT(11,2)
        )";

        $result = $this->createTable($userTableSql);

        return $result;
    }

}
