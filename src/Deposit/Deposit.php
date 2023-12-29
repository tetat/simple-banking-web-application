<?php

namespace App\Deposit;

require_once __DIR__ . "/../DB/CreateConnection.php";
// require_once __DIR__ . "/../Helper/UserInfo.php";
require_once __DIR__ . "/../Helper/UpdateBalance.php";

use App\DB\CreateConnection;
use App\Helper\UpdateBalance;
// use App\Helper\UserInfo;

use PDO;

class Deposit {

    private int $user_id;
    private float $amount;
    private string $type;
    private string $date;
    
    private string $email;
    private PDO $connection;

    public function __construct(array $deposit) {

        $this->email = htmlspecialchars($deposit['email']);
        $this->connection = (new CreateConnection())->createConnection();

        $this->user_id = $deposit['id'];
        $this->type = "Deposit";
        $this->amount = $deposit['amount'];
        $this->date = date("d/m/Y h:i:s");

    }

    public function deposit() {

        $message = "";

        try {

            $stmt = $this->connection->prepare("INSERT INTO transactions (user_id, type, amount, date) VALUES (?, ?, ?, ?)");
            $result =  $stmt->execute([$this->user_id, $this->type, $this->amount, $this->date]);

            if ($result && $this->amount > 0) {

                (new UpdateBalance($this->connection))->depositBalance($this->user_id, $this->amount);
            
                $message = "success";

            } else {

                $message = "Database error: Failed to Deposit";

            }

        } catch (\PDOException $e) {

            $message = "Databse error: {$e->getMessage()}";

        }

        return $message;

    }
}

// $dep = new Deposit("solim@gmail.com", 130);
// echo $dep->deposit();