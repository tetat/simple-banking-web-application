<?php

require_once __DIR__ . "/../../src/DB/CreateConnection.php";
require_once __DIR__ . "/../../src/Helper/UserInfo.php";

use App\DB\CreateConnection;
use App\Helper\UserInfo;

session_start();

if (!isset($_SESSION['user_role'])) {

  header("Location:../../Admin.php");
  exit;

}

$connection = (new CreateConnection())->createConnection();

$userInfo = new UserInfo($connection);

$id = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
$userEmail = $userInfo->getUserEmail($id);

$users = $userInfo->getUsers();

?>



<!DOCTYPE html>
<html
  class="h-full bg-gray-100"
  lang="en">
  <head>
    
    <!-- Head section -->
    <?php require("../Common/Head.html") ?>

    <title>All Customers</title>
  </head>
  <body class="h-full">
    <div class="min-h-full">
      <div class="pb-32 bg-sky-600">
        <!-- Navigation -->
        <?php require("../Common/AdminNav.html") ?>

        <header class="py-10">
          <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">
              Customers
            </h1>
          </div>
        </header>
      </div>

      <main class="-mt-32">
        <div class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="py-8 bg-white rounded-lg">
            <!-- List of All The Customers -->
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                  <p class="mt-2 text-sm text-gray-600">
                    A list of all the customers including their name, email and
                    profile picture.
                  </p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                  <a
                    href="./AddCustomer.php"
                    type="button"
                    class="block px-3 py-2 text-sm font-semibold text-center text-white rounded-md shadow-sm bg-sky-600 hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                    Add Customer
                  </a>
                </div>
              </div>

              <!-- Users List -->
              <div class="flow-root mt-8">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <ul
                    role="list"
                    class="divide-y divide-gray-100">
                        <?php foreach ($users as $user) { ?>
                    <li
                      class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                      <div class="flex gap-x-4">
                        <!-- You can either use image or name initials as avatar -->
                        <!-- <img
                          class="flex-none w-12 h-12 rounded-full bg-gray-50"
                          src="https://avatars.githubusercontent.com/u/61485238"
                          alt="Al Nahian" /> -->
                        <span
                          class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-sky-500">
                          <span
                            class="text-xl font-medium leading-none text-white"
                            ><?=strtoupper(mb_substr($user['name'], 0, 1))?></span
                          >
                        </span>

                        <div class="flex-auto min-w-0">
                          <p
                            class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="./CustomerTransactions.php?id=<?=$user['id']?>">
                              <span
                                class="absolute inset-x-0 bottom-0 -top-px"></span>
                                <?=$user['name']?>
                            </a>
                          </p>
                          <p class="flex mt-1 text-xs leading-5 text-gray-500">
                            <a
                              href="./customer_transactions.html"
                              class="relative truncate hover:underline"
                              ><?=$user['email']?></a
                            >
                          </p>
                        </div>
                      </div>
                    </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>