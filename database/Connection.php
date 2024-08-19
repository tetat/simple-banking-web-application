<?php

namespace Database;

use PDO;
use Dotenv\Dotenv;
use App\Core\CommonException;
use App\Core\Session;

class Connection
{
    public function create()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $database = env('DB_CONNECTION');
        $config = require_once __DIR__ . '/../config/database.php';
        
        $config = $config[$database];
        Session::put('driver', $database);
        if ($database === 'mysql') {
            try {
                $db = new PDO("mysql:host={$config['host']};dbname={$config['database']};", $config['username'], $config['password']);
    
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
                return $db;
            } catch (\PDOException $e) {
                CommonException::throw(
                    [
                        'alert' => ["dberror" => "Database connectin failed!"],
                    ]
                );
            }
        }
        return [];
    }
}