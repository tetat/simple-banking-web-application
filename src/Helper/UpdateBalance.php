<?php

namespace App\Helper;

use PDO;

class UpdateBalance {

    private PDO $connection;

    public function __construct(PDO $connection) {

        $this->connection = $connection;

    }

    public function depositBalance(int $user_id, float $amount) {

        $balance = (new UserInfo($this->connection))->getUserBalance($user_id);

        $balance += $amount;

        $stmt = $this->connection->prepare("UPDATE users SET balance = ? WHERE id = ?");
        $stmt->execute([$balance, $user_id]);

        return "success";

    }

    public function withdrawBalance(int $user_id, float $amount) {

        $balance = (new UserInfo($this->connection))->getUserBalance($user_id);

        if ($balance >= $amount) $balance -= $amount;

        $stmt = $this->connection->prepare("UPDATE users SET balance = ? WHERE id = ?");
        $stmt->execute([$balance, $user_id]);

        return "success";

    }

}