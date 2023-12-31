<?php

require_once __DIR__ . "/../../src/DB/CreateConnection.php";

use App\DB\CreateConnection;
use App\Helper\UserInfo;
use App\Register\Register;

session_start();

if (!isset($_SESSION['user_role'])) {

    header("Location:../../Admin.php");
    exit;

}

$connection = (new CreateConnection())->createConnection();
$userInfo = new UserInfo($connection);

$userName = $_SESSION['user_name'];
$userEmail = $userInfo->getUserEmail($_SESSION['user_id']);

// Register section
if (isset($_POST['first-name']) && isset($_POST['last-name']) && isset($_POST['email']) && isset($_POST['password'])) {
  $name = htmlspecialchars($_POST['first-name'] . " " . $_POST['last-name']);
  $email = htmlspecialchars($_POST['email']);
  $password = $_POST['password'];

  $customer = array("name" => $name, "email" => $email, "password" => $password, "role" => "customer");

  if (filter_var($customer['email'], FILTER_VALIDATE_EMAIL)) {
    
    $result = (new Register($customer))->register();

    if ($result === "success") {

      header("Location:Customers.php");
      exit;
  
    } else {

      echo $result;
  
    }

  } else {

    echo"enter valid email";

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

    <title>Add a New Customer</title>
  </head>
  <body class="h-full">
    <div class="min-h-full">
      <div class="pb-32 bg-sky-600">
        <!-- Navigation -->
        <?php require("../Common/AdminNav.html") ?>

        <header class="py-10">
          <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">
              Add a New Customer
            </h1>
          </div>
        </header>
      </div>

      <main class="-mt-32">
        <div class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="bg-white rounded-lg">
            <form action="#" method="POST"
              class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
              <div class="px-4 py-6 sm:p-8">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                  <div class="sm:col-span-3">
                    <label
                      for="first-name"
                      class="block text-sm font-medium leading-6 text-gray-900"
                      >First Name</label
                    >
                    <div class="mt-2">
                      <input
                        type="text"
                        name="first-name"
                        id="first-name"
                        autocomplete="given-name"
                        required
                        class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                    </div>
                  </div>

                  <div class="sm:col-span-3">
                    <label
                      for="last-name"
                      class="block text-sm font-medium leading-6 text-gray-900"
                      >Last Name</label
                    >
                    <div class="mt-2">
                      <input
                        type="text"
                        name="last-name"
                        id="last-name"
                        autocomplete="family-name"
                        required
                        class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                    </div>
                  </div>

                  <div class="sm:col-span-3">
                    <label
                      for="email"
                      class="block text-sm font-medium leading-6 text-gray-900"
                      >Email Address</label
                    >
                    <div class="mt-2">
                      <input
                        type="email"
                        name="email"
                        id="email"
                        autocomplete="email"
                        required
                        class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                    </div>
                  </div>

                  <div class="sm:col-span-3">
                    <label
                      for="password"
                      class="block text-sm font-medium leading-6 text-gray-900"
                      >Password</label
                    >
                    <div class="mt-2">
                      <input
                        type="password"
                        name="password"
                        id="password"
                        autocomplete="password"
                        required
                        class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                <button
                  type="reset"
                  class="text-sm font-semibold leading-6 text-gray-900">
                  Cancel
                </button>
                <button
                  type="submit"
                  class="px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-sky-600 hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                  Create Customer
                </button>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>