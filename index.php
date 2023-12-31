<?php

session_start();

if (isset($_SESSION['user_role'])) {

  if ($_SESSION['user_role'] === "customer") {
      header("Location:UI/CustomerUI/DashboardUI.php");
  } else {
      header("Location:UI/Admin/Customers.php");
  }

exit;

}

?>



<!DOCTYPE html>
<html
  class="h-full bg-white"
  lang="en">
  <head>
    <!-- Head section -->
    <?php require("./UI/Common/Head.html") ?>


    <title>Simple Banking</title>
  </head>
  <body class="flex flex-col items-baseline justify-center min-h-screen">
    <section
      class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-16 lg:px-12">
      <h1
        class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-4xl">
        Simple Banking Web Application
      </h1>
      <p
        class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48">
          This is a simple banking application with features for both 'Admin' and 'Customer' users.
      </p>
      <div
        class="flex flex-col gap-2 mb-8 lg:mb-16 md:flex-row md:justify-center">
        <a
          href="./UI/Auth/LoginUI.php"
          type="button"
          class="text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
          Login
        </a>

        <a
          href="./UI/Auth/RegisterUI.php"
          type="button"
          class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">
          Register
        </a>
        
      </div>
    </section>
  </body>
</html>