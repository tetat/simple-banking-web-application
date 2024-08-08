<?php

$title = "All Customers";

?>

<!DOCTYPE html>
<html
  class="h-full bg-gray-100"
  lang="en">

  <!-- head section -->
  <?php include(__DIR__ . "/../layouts/head-with-alpine.php") ?>

  <body class="h-full">
    <div class="min-h-full">
      <div class="pb-32 bg-sky-600">
        
        <!-- Navigation -->
        <?php include(__DIR__ . "/../layouts/admin-navbar.php") ?>

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
                    href="./add_customer.html"
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
                            >AN</span
                          >
                        </span>

                        <div class="flex-auto min-w-0">
                          <p
                            class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="./customer_transactions.html">
                              <span
                                class="absolute inset-x-0 bottom-0 -top-px"></span>
                              Al Nahian
                            </a>
                          </p>
                          <p class="flex mt-1 text-xs leading-5 text-gray-500">
                            <a
                              href="./customer_transactions.html"
                              class="relative truncate hover:underline"
                              >alnahian@2003.com</a
                            >
                          </p>
                        </div>
                      </div>
                    </li>

                    <li
                      class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                      <div class="flex gap-x-4">
                        <!-- Use Image or Name Initials -->
                        <!-- <img
                          class="flex-none w-12 h-12 rounded-full bg-gray-50"
                          src="https://avatars.githubusercontent.com/u/44245907"
                          alt="Muntaser Muttaqi" /> -->
                        <span
                          class="inline-flex items-center justify-center w-12 h-12 bg-purple-500 rounded-full">
                          <span
                            class="text-xl font-medium leading-none text-white"
                            >MM</span
                          >
                        </span>
                        <div class="flex-auto min-w-0">
                          <p
                            class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="./customer_transactions.html">
                              <span
                                class="absolute inset-x-0 bottom-0 -top-px"></span>
                              Muntaser Muttaqi
                            </a>
                          </p>
                          <p class="flex mt-1 text-xs leading-5 text-gray-500">
                            <a
                              href="./customer_transactions.html"
                              class="relative truncate hover:underline"
                              >muntaser@muttaqi.com</a
                            >
                          </p>
                        </div>
                      </div>
                    </li>

                    <li
                      class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                      <div class="flex gap-x-4">
                        <!-- <img
                          class="flex-none w-12 h-12 rounded-full bg-gray-50"
                          src="https://avatars.githubusercontent.com/u/1510147"
                          alt="Povilas Korop" /> -->
                        <span
                          class="inline-flex items-center justify-center w-12 h-12 bg-teal-500 rounded-full">
                          <span
                            class="text-xl font-medium leading-none text-white"
                            >PK</span
                          >
                        </span>
                        <div class="flex-auto min-w-0">
                          <p
                            class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="./customer_transactions.html">
                              <span
                                class="absolute inset-x-0 bottom-0 -top-px"></span>
                              Povilas Korop
                            </a>
                          </p>
                          <p class="flex mt-1 text-xs leading-5 text-gray-500">
                            <a
                              href="./customer_transactions.html"
                              class="relative truncate hover:underline"
                              >povilas@korop.com</a
                            >
                          </p>
                        </div>
                      </div>
                    </li>

                    <li
                      class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                      <div class="flex gap-x-4">
                        <!-- Use Avatar or Name Initials -->
                        <!-- <img
                          class="flex-none w-12 h-12 rounded-full bg-gray-50"
                          src="https://avatars.githubusercontent.com/u/958072"
                          alt="Laravel Framework" /> -->
                        <span
                          class="inline-flex items-center justify-center w-12 h-12 bg-red-500 rounded-full">
                          <span
                            class="text-xl font-medium leading-none text-white"
                            >LF</span
                          >
                        </span>
                        <div class="flex-auto min-w-0">
                          <p
                            class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="./customer_transactions.html">
                              <span
                                class="absolute inset-x-0 bottom-0 -top-px"></span>
                              Laravel Framework
                            </a>
                          </p>
                          <p class="flex mt-1 text-xs leading-5 text-gray-500">
                            <a
                              href="./customer_transactions.html"
                              class="relative truncate hover:underline"
                              >laravel@framework.com</a
                            >
                          </p>
                        </div>
                      </div>
                    </li>

                    <li
                      class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                      <div class="flex gap-x-4">
                        <!-- Use Avatar or Name Initials -->
                        <!-- <img
                          class="flex-none w-12 h-12 rounded-full bg-gray-50"
                          src="https://avatars.githubusercontent.com/u/183223"
                          alt="Jeffrey Way" /> -->
                        <span
                          class="inline-flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full">
                          <span
                            class="text-xl font-medium leading-none text-white"
                            >JW</span
                          >
                        </span>
                        <div class="flex-auto min-w-0">
                          <p
                            class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="./customer_transactions.html">
                              <span
                                class="absolute inset-x-0 bottom-0 -top-px"></span>
                              Jeffrey Way
                            </a>
                          </p>
                          <p class="flex mt-1 text-xs leading-5 text-gray-500">
                            <a
                              href="./customer_transactions.html"
                              class="relative truncate hover:underline"
                              >jeffrey@way.com</a
                            >
                          </p>
                        </div>
                      </div>
                    </li>

                    <li
                      class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                      <div class="flex gap-x-4">
                        <!-- Use Avatar or Name Initilas -->
                        <!-- <img
                          class="flex-none w-12 h-12 rounded-full bg-gray-50"
                          src="https://avatars.githubusercontent.com/u/1692996?v=4"
                          alt="Alex Garrett-Smith" /> -->

                        <span
                          class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-500">
                          <span
                            class="text-xl font-medium leading-none text-white"
                            >AG</span
                          >
                        </span>
                        <div class="flex-auto min-w-0">
                          <p
                            class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="./customer_transactions.html">
                              <span
                                class="absolute inset-x-0 bottom-0 -top-px"></span>
                              Alex Garrett-Smith
                            </a>
                          </p>
                          <p class="flex mt-1 text-xs leading-5 text-gray-500">
                            <a
                              href="./customer_transactions.html"
                              class="relative truncate hover:underline"
                              >alex@smith.com</a
                            >
                          </p>
                        </div>
                      </div>
                    </li>
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
