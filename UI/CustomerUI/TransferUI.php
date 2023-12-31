<?php

require_once __DIR__ . "/../../src/DB/CreateConnection.php";
require_once __DIR__ . "/../../src/Transfer/Transfer.php";
require_once __DIR__ . "/../../src/Helper/UserInfo.php";

use App\DB\CreateConnection;
use App\Helper\UserInfo;
use App\Withdraw\Transfer;

session_start();

if (!isset($_SESSION['user_role'])) {

  header("Location:../../index.php");
  exit;

}

$connection = (new CreateConnection())->createConnection();
$userInfo = new UserInfo($connection);

$id = $_SESSION['user_id'];
$name = $_SESSION['user_name'];
$email = $userInfo->getUserEmail($id);

if (isset($_POST['email']) && isset($_POST['amount'])) {

  $recipient_email = htmlspecialchars($_POST['email']);
  $recipient_id = $userInfo->getUserId($recipient_email);
  $recipient_name = $userInfo->getUserName($recipient_id);

  $transferInfo = array(
    "id" => $id,
    "email" => $email,
    "recipient_id" => $recipient_id,
    "recipient_name" => htmlspecialchars($recipient_name),
    "recipient_email" => $recipient_email,
    "amount" => $_POST['amount'],
    "connection" => $connection
  );

  $message = (new Transfer($transferInfo))->transfer();

  if ($message === "success") {

    header("Location:DashboardUI.php");
    exit;

  } else {

    echo $message;

  }
}

?>


<!DOCTYPE html>
<html
  class="h-full bg-gray-100"
  lang="en">
  <head>
    <!-- Head section -->
    <?php require("../Common/Head.html") ?>

    <title>Transfer Balance</title>
  </head>
  <body class="h-full">
    <div class="min-h-full">
      <div class="bg-emerald-600 pb-32">
        <!-- Navigation -->
        
        <?php require("../Common/CustomerNav.html") ?>

        <header class="py-10">
          <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">
              Transfer Balance
            </h1>
          </div>
        </header>
      </div>

      <main class="-mt-32">
        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
          <div class="bg-white rounded-lg p-2">
            <!-- Current Balance Stat -->
            <dl
              class="mx-auto grid grid-cols-1 gap-px sm:grid-cols-2 lg:grid-cols-4">
              <div
                class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-10 sm:px-6 xl:px-8">
                <dt class="text-sm font-medium leading-6 text-gray-500">
                  Current Balance
                </dt>
                <dd
                  class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
                  $<?=$userInfo->getUserBalance($id)?>
                </dd>
              </div>
            </dl>

            <hr />
            <!-- Transfer Form -->
            <div class="sm:rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <div class="mt-4 text-sm text-gray-500">
                  <form
                    action="#"
                    method="POST">
                    <!-- Recipient's Email Input -->
                    <input
                      type="email"
                      name="email"
                      id="email"
                      class="block w-full ring-0 outline-none py-2 text-gray-800 border-b placeholder:text-gray-400 md:text-4xl"
                      placeholder="Recipient's Email Address"
                      required />

                    <!-- Amount -->
                    <div class="relative mt-4 md:mt-8">
                      <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-0">
                        <span class="text-gray-400 md:text-4xl">$</span>
                      </div>
                      <input
                        type="number"
                        name="amount"
                        id="amount"
                        class="block w-full ring-0 outline-none pl-4 py-2 md:pl-8 text-gray-800 border-b border-b-emerald-500 placeholder:text-gray-400 md:text-4xl"
                        placeholder="0.00"
                        required />
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-5">
                      <button
                        type="submit"
                        class="w-full px-6 py-3.5 text-base font-medium text-white bg-emerald-600 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 rounded-lg md:text-xl text-center">
                        Proceed
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>