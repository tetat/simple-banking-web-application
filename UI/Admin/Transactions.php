<?php

require_once __DIR__ . "/../../src/DB/CreateConnection.php";

use App\DB\CreateConnection;
use App\Helper\TransactionInfo;
use App\Helper\UserInfo;

session_start();

if (!isset($_SESSION['user_role'])) {

  header("Location:../../Admin.php");
  exit;

}


$connection = (new CreateConnection())->createConnection();
$transactions = (new TransactionInfo($connection))->getAllTransactions();
$userInfo = new UserInfo($connection);


$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
$userEmail = $userInfo->getUserEmail($userId);

?>

<!DOCTYPE html>
<html
  class="h-full bg-gray-100"
  lang="en">
  <head>
    <!-- Head section -->
    <?php require("../Common/Head.html") ?>

    <title>Transactions</title>
  </head>
  <body class="h-full">
    <div class="min-h-full">
      <div class="bg-sky-600 pb-32">
        <!-- Navigation -->
        <?php require("../Common/AdminNav.html") ?>

        <header class="py-10">
          <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">
              Transactions
            </h1>
          </div>
        </header>
      </div>

      <main class="-mt-32">
        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
          <div class="bg-white rounded-lg py-8">
            <!-- List of All The Transactions -->
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                  <p class="mt-2 text-sm text-gray-700">
                    List of transactions made by the customers.
                  </p>
                </div>
              </div>
              <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div
                    class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                      <thead>
                        <tr>
                          <th
                            scope="col"
                            class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            Customer Name
                          </th>
                          <th
                            scope="col"
                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Amount
                          </th>
                          <th
                            scope="col"
                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Date
                          </th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 bg-white">
                        <?php foreach ($transactions as $transaction) { ?>
                        <tr>
                          <td
                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-800 sm:pl-0">
                            <?=$userInfo->getUserName($transaction['user_id'])?>
                          </td>
                          <?php if ($transaction['type'] === "Deposit") { ?>
                          <td
                            class="whitespace-nowrap px-2 py-4 text-sm font-medium text-emerald-600">
                            +$<?=$transaction['amount']?>
                          </td>
                          <?php } else { ?>
                            <td
                            class="whitespace-nowrap px-2 py-4 text-sm font-medium text-red-600">
                            -$<?=$transaction['amount']?>
                            </td>
                          <?php } ?>
                          <td
                            class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">
                            <?=$transaction['date']?>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>