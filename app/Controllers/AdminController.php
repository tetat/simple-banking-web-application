<?php

namespace App\Controllers;

class AdminController
{
    public function customers()
    {
        view("admin/customers");
    }

    public function transactions()
    {
        view("admin/transactions");
    }
}