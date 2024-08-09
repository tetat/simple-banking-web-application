<?php

use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Controllers\DepositController;
use App\Controllers\SessionController;
use App\Controllers\CustomerController;
use App\Controllers\RegisterController;
use App\Controllers\TransferController;
use App\Controllers\WithdrawController;

// GET route section
$router->get("/", [HomeController::class, "home"]);

$router->get("/login/create", [SessionController::class, "create"])->middleware('guest');
$router->get("/register/create", [RegisterController::class, "create"])->middleware('guest');
$router->get("/add/customer", [AdminController::class, "createCustomer"])->middleware('admin');

$router->get("/customers", [AdminController::class, "customers"])->middleware('admin');
$router->get("/customers/transactions", [AdminController::class, "allTransactions"])->middleware('admin');
$router->get("/customer/transactions", [AdminController::class, "userTransactions"])->middleware('admin');

$router->get("/customer/dashboard", [CustomerController::class, "dashboard"])->middleware('customer');
$router->get("/customer/deposit", [DepositController::class, "create"])->middleware('customer');
$router->get("/customer/withdraw", [WithdrawController::class, "create"])->middleware('customer');
$router->get("/customer/transfer", [TransferController::class, "create"])->middleware('customer');
// End GET route section

// POST route section
$router->post("/login/store", [SessionController::class, "store"])->middleware('guest');
$router->post("/register/store", [RegisterController::class, "store"])->middleware('guest');
$router->post("/add/customer", [RegisterController::class, "store"])->middleware('admin');

$router->post("/customer/deposit", [DepositController::class, "store"])->middleware('customer');
$router->post("/customer/withdraw", [WithdrawController::class, "store"])->middleware('customer');
$router->post("/customer/transfer", [TransferController::class, "store"])->middleware('customer');

$router->post("/customer/deposit", [DepositController::class, "store"])->middleware('customer');
$router->post("/customer/withdraw", [WithdrawController::class, "store"])->middleware('customer');
$router->post("/customer/transfer", [TransferController::class, "store"])->middleware('customer');
// End POST route section

// DELETE route section
$router->delete("/logout", [SessionController::class, "destroy"])->middleware('user');
// End DELETE route section