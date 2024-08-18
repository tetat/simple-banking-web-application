<?php

use Database\BalanceTable;
use Database\Connection;
use Database\TransactionTable;
use Database\UserTable;

require_once __DIR__ . "/vendor/autoload.php";

$db = Connection::create();

// create users table
UserTable::create($db);
// create balances table
BalanceTable::create($db);
// create transactions table
TransactionTable::create($db);

echo 'Table create successfully.';