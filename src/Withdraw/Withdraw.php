<?php

namespace App\Withdraw;

require_once __DIR__ . "/../Helper/UpdateBalance.php";
require_once __DIR__ . "/../DB/TransactionTable.php";

use App\DB\TransationTable;
use App\Helper\UpdateBalance;

use PDO;

class Withdraw {

    private int $user_id;
    private float $amount;
    private string $type;
    private string $date;
    
    private string $email;
    private PDO $connection;

    public function __construct(array $withdrawInfo) {

        $this->email = htmlspecialchars($withdrawInfo['email']);
        $this->connection = $withdrawInfo['connection'];

        $this->user_id = $withdrawInfo['id'];
        $this->type = "Withdraw";
        $this->amount = $withdrawInfo['amount'];
        $this->date = date("d/m/Y h:i:s");

    }

    public function withdraw() {

        $message = (new TransationTable())->createTransactionTable();

        if ($message !== "success") return $message;

        $message = "";

        try {

            $stmt = $this->connection->prepare("INSERT INTO transactions (user_id, type, amount, date) VALUES (?, ?, ?, ?)");
            $result =  $stmt->execute([$this->user_id, $this->type, $this->amount, $this->date]);

            if ($result && $this->amount > 0) {

                (new UpdateBalance($this->connection))->withdrawBalance($this->user_id, $this->amount);
            
                $message = "success";

            } else {

                $message = "Database error: Failed to Withdraw";

            }

        } catch (\PDOException $e) {

            $message = "Databse error: {$e->getMessage()}";

        }

        return $message;

    }

}
