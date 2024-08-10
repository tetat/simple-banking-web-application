<?php

namespace App\Middleware;

use App\Constants\ViewPath;
use App\Core\CommonException;

class User
{
    public function handle()
    {
        if (empty($_SESSION['user'])) {
            CommonException::throw(
                [
                    'alert' => ["403" => "You are not allowed to access your requested page."],
                ],
                [],
                ViewPath::HOME
            );
        }
    }
}