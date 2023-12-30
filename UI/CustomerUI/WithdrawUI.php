<?php

require_once __DIR__ . "/../../src/DB/CreateConnection.php";
require_once __DIR__ . "/../../src/Helper/UserInfo.php";

use App\DB\CreateConnection;
use App\Helper\UserInfo;
use App\Withdraw\Withdraw;

session_start();

if (!isset($_SESSION['user_id'])) {

  header("Location:../Auth/LoginUI.php");
  exit;

}

$connection = (new CreateConnection())->createConnection();
$userInfo = new UserInfo($connection);

$id = $_SESSION['user_id'];
$name = $_SESSION['user_name'];
$email = $userInfo->getUserEmail($id);

if (isset($_POST['amount'])) {

  $withdrawInfo = array("id" => $id, "email" => $email, "amount" => $_POST['amount'], "connection" => $connection);
  $message = (new Withdraw($withdrawInfo))->withdraw();

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
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0" />

    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS CDN -->
    <script
      defer
      src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Inter Font -->
    <link
      rel="preconnect"
      href="https://fonts.googleapis.com" />
    <link
      rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
      rel="stylesheet" />
    <style>
      * {
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
          'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
          'Helvetica Neue', sans-serif;
      }
    </style>

    <title>Withdraw Balance</title>
  </head>
  <body class="h-full">
    <div class="min-h-full">
      <div class="bg-emerald-600 pb-32">
        <!-- Navigation -->
        
        <?php require("../Common/CustomerNav.html") ?>

        <header class="py-10">
          <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">
              Withdaw Balance
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
            <!-- Withdaw Form -->
            <div class="sm:rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-semibold leading-6 text-gray-800">
                  Withdaw Money From Your Account
                </h3>
                <div class="mt-4 text-sm text-gray-500">
                  <form
                    action="#"
                    method="POST">
                    <!-- Input Field -->
                    <div class="relative mt-2 rounded-md">
                      <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-0">
                        <span class="text-gray-400 sm:text-4xl">$</span>
                      </div>
                      <input
                        type="number"
                        name="amount"
                        id="amount"
                        class="block w-full ring-0 outline-none text-xl pl-4 py-2 sm:pl-8 text-gray-800 border-b border-b-emerald-500 placeholder:text-gray-400 sm:text-4xl"
                        placeholder="0.00"
                        required />
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-5">
                      <button
                        type="submit"
                        class="w-full px-6 py-3.5 text-base font-medium text-white bg-emerald-600 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 rounded-lg sm:text-xl text-center">
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