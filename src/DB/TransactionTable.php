<?php

namespace App\DB;

require __DIR__ . "/CreateTable.php";
use App\DB\CreateTable;

class TransationTable {

    use CreateTable;
    
    public function createTransactionTable() {
        
        $transactionsTableSql = "CREATE TABLE IF NOT EXISTS transactions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            type VARCHAR(100),
            amount FLOAT(9,2),
            date VARCHAR(100)
        )";

        $result = $this->createTable($transactionsTableSql);

        return $result;
    }

}
