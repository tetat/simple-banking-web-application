<?php

namespace App\DB;

require '../../vendor/autoload.php';

use Dotenv\Dotenv;
use PDO;

class CreateConnection {

    private string $db_host;
    private string $db_name;
    private string $db_user;
    private string $db_password;

    public function __construct() {

        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();

        $this->db_host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->db_user = $_ENV['DB_USER'];
        $this->db_password = $_ENV['DB_PASSWORD'];

    }

    public function createConnection() {
        
        try {

            $pdo = new PDO("mysql:host={$this->db_host};dbname={$this->db_name};", $this->db_user, $this->db_password);
        
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
            return $pdo;

        } catch (\PDOException $e) {

            die("Database connnection failed: {$e->getMessage()}");
            exit;
            
        }

    }

}

// (new CreateConnection())->createConnection();