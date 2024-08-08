<?php

namespace App\Middleware\Auth;

use App\Constants\UserRole;
use App\Constants\ViewPath;

class Admin
{
    public function handle()
    {
        if (empty($_SESSION['user'])) {
            redirect(previousPage());
        }

        if ($_SESSION['user']->role !== UserRole::ADMIN) {
            redirect(ViewPath::DASHBOARD);
        }
    }
}