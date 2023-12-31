<?php

namespace App\DB;

require_once __DIR__ . "/CreateConnection.php";

trait CreateTable {

    public function createTable(string $sql) {
        
        try {

            $connection = (new CreateConnection())->createConnection();
            $connection->exec($sql);

            return "Table Create Successfully.";

        } catch (\PDOException $e) {

            die("Creating Table failed: {$e->getMessage()}");
            exit;

        }
        
    }

}