<?php

namespace Database;

use PDO;
use Dotenv\Dotenv;
use App\Core\CommonException;
use App\Core\Session;

class Connection
{
    protected PDO $db;

    public function __construct(array $config)
    {        
        try {
            $this->db = new PDO("mysql:host={$config['host']};dbname={$config['database']};", $config['username'], $config['password']);

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            CommonException::throw(
                [
                    'alert' => ["dberror" => "Database connectin failed!"],
                ]
            );
        }
    }

    public static function create()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $database = env('DB_CONNECTION');
        $config = require_once __DIR__ . '/../config/database.php';

        Session::put('driver', $database);

        if ($database === 'mysql') {
            $instance = new static($config[$database]);
            return $instance->db;
        }

        // return [];
    }
}