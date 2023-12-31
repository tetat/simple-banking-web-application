<?php

namespace App\Withdraw;

require_once __DIR__ . "/../Helper/UpdateBalance.php";

use App\DB\TransferTable;
use App\Helper\UpdateBalance;

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

    public function __construct(array $transferInfo) {

        $this->email = htmlspecialchars($transferInfo['email']);
        $this->connection = $transferInfo['connection'];

        $this->user_id = $transferInfo['id'];
        $this->recipient_id = $transferInfo['recipient_id'];
        $this->recipient_name = $transferInfo['recipient_name'];
        $this->recipient_email = $transferInfo['recipient_email'];
        $this->amount = $transferInfo['amount'];
        $this->date = date("d/m/Y h:i:s");

    }

    public function transfer() {

        $message = (new TransferTable())->createTransferTable();

        if ($message !== "success") return $message;

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
