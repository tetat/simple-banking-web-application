<?php

namespace App\Deposit;

require_once __DIR__ . "/../Helper/UpdateBalance.php";
require_once __DIR__ . "/../DB/TransactionTable.php";

use App\DB\TransationTable;
use App\Helper\UpdateBalance;

use PDO;

class Deposit {

    private int $user_id;
    private float $amount;
    private string $type;
    private string $date;
    
    private string $email;
    private PDO $connection;

    public function __construct(array $depositInfo) {

        $this->email = htmlspecialchars($depositInfo['email']);
        $this->connection = $depositInfo['connection'];

        $this->user_id = $depositInfo['id'];
        $this->type = "Deposit";
        $this->amount = $depositInfo['amount'];
        $this->date = date("d/m/Y h:i:s");

    }

    public function deposit() {

        $message = (new TransationTable())->createTransactionTable();

        if ($message !== "success") return $message;

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
