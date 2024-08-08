<?php

namespace App\Middleware\Auth;

use App\Constants\UserRole;
use App\Constants\ViewPath;

class Customer
{
    public function handle()
    {
        if (empty($_SESSION['user'])) {
            redirect(previousPage());
        }

        if ($_SESSION['user']->role !== UserRole::CUSTOMER) {
            redirect(ViewPath::CUSTOMERS);
        }
    }
}