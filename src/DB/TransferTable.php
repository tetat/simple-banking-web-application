<?php

namespace App\DB;

require __DIR__ . "/CreateTable.php";
use App\DB\CreateTable;

class TransferTable {

    use CreateTable;
    
    public function createTransferTable() {
        
        $moneyTransferTableSql = "CREATE TABLE IF NOT EXISTS moneytransfer (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            recipient_name VARCHAR(100),
            recipient_email VARCHAR(100),
            amount FLOAT(9,2),
            date VARCHAR(100)
        )";

        echo $this->createTable($moneyTransferTableSql);
    }

}
