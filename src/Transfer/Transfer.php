<?php

namespace App\Withdraw;

require_once __DIR__ . "/../DB/CreateConnection.php";
require_once __DIR__ . "/../Helper/UserInfo.php";
require_once __DIR__ . "/../Helper/UpdateBalance.php";

use App\DB\CreateConnection;
use App\Helper\UpdateBalance;
use App\Helper\UserInfo;

use PDO;

class Transfer {

    private int $user_id;
    private int $recipient_id;
    private string $recipient_name;
    private string $recipient_email;
    private float $amount;
    private string $date;
    
    private string $email;
    private PDO $connection;

    public function __construct(string $email, string $recipient_name, string $recipient_email, int $amount) {

        $this->email = htmlspecialchars($email);
        $this->connection = (new CreateConnection())->createConnection();

        $this->user_id = (new UserInfo($this->connection))->getUserId($this->email);
        $this->recipient_name = htmlspecialchars($recipient_name);
        $this->recipient_email = htmlspecialchars($recipient_email);
        $this->recipient_id = (new UserInfo($this->connection))->getUserId($this->recipient_email);
        $this->amount = $amount;
        $this->date = date("d/m/Y h:i:s");

    }

    public function transfer() {

        $message = "";

        try {

            $stmt = $this->connection->prepare("INSERT INTO moneytransfer (user_id, recipient_name, recipient_email, amount, date) VALUES (?, ?, ?, ?, ?)");
            $result =  $stmt->execute([$this->user_id, $this->recipient_name, $this->recipient_email, $this->amount, $this->date]);

            if ($result && $this->amount > 0) {

                $update = new UpdateBalance($this->connection);
                $update->withdrawBalance($this->user_id, $this->amount);
                $update->depositBalance($this->recipient_id, $this->amount);

                $message = "success";

            } else {

                $message = "Database error: Failed to Transfer";

            }

        } catch (\PDOException $e) {

            $message = "Databse error: {$e->getMessage()}";

        }

        return $message;

    }

}

$trn = new Transfer("solim@gmail.com", "solim", "n@gmail.com", 20);
echo $trn->transfer();