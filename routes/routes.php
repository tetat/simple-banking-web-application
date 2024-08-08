<?php

use App\Controllers\AdminController;
use App\Controllers\GuestController;
use App\Controllers\DepositController;
use App\Controllers\SessionController;
use App\Controllers\CustomerController;
use App\Controllers\RegisterController;
use App\Controllers\TransferController;
use App\Controllers\WithdrawController;

// GET route section
$router->get("/", [GuestController::class, "home"])->middleware('guest');

$router->get("/login/create", [SessionController::class, "create"])->middleware('guest');
$router->get("/register/create", [RegisterController::class, "create"])->middleware('guest');

$router->get("/admin/customers", [AdminController::class, "customers"])->middleware('admin');
$router->get("/admin/transactions", [AdminController::class, "transactions"])->middleware('admin');

$router->get("/customer/dashboard", [CustomerController::class, "dashboard"])->middleware('customer');
$router->get("/customer/deposit", [DepositController::class, "create"])->middleware('customer');
$router->get("/customer/withdraw", [WithdrawController::class, "create"])->middleware('customer');
$router->get("/customer/transfer", [TransferController::class, "create"])->middleware('customer');


// POST route section
$router->post("/login/store", [SessionController::class, "store"])->middleware('guest');
$router->post("/register/store", [RegisterController::class, "store"])->middleware('guest');

$router->post("/customer/transfer", [TransferController::class, "store"])->middleware('customer');

$router->post("/customer/deposit", [DepositController::class, "store"])->middleware('customer');
$router->post("/customer/withdraw", [WithdrawController::class, "store"])->middleware('customer');
$router->post("/customer/transfer", [TransferController::class, "store"])->middleware('customer');


// PATCH route section



// DELETE route section
$router->delete("/logout", [SessionController::class, "destroy"])->middleware('user');