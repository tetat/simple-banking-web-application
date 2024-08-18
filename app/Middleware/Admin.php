<?php

namespace App\Middleware;

use App\Core\Session;
use App\Constants\UserRole;
use App\Constants\ViewPath;
use App\Core\CommonException;

class Admin
{
    public function handle()
    {
        $user = Session::get('user', []);

        if (empty($user)) {
            CommonException::throw(
                [
                    'alert' => ["401" => "You are not authentic user."],
                ],
                [],
                ViewPath::HOME
            );
        }

        if ($user['role'] !== UserRole::ADMIN) {
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