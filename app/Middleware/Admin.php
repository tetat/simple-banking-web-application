<?php

namespace App\Middleware;

use App\Constants\UserRole;
use App\Constants\ViewPath;
use App\Core\CommonException;

class Admin
{
    public function handle()
    {
        if (empty($_SESSION['user'])) {
            CommonException::throw(
                [
                    'alert' => ["401" => "You are not authentic user."],
                ],
                [],
                ViewPath::HOME
            );
        }

        if ($_SESSION['user']->role !== UserRole::ADMIN) {
            CommonException::throw(
                [
                    'alert' => ["403" => "You are not allowed to access your requested page."],
                ],
                [],
                ViewPath::DASHBOARD
            );
        }
    }
}