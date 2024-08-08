<?php

namespace App\Middleware;

use App\Constants\ViewPath;

class Guest
{
    public function handle()
    {
        if (isset($_SESSION['user'])) {
            redirect(ViewPath::HOME);
        }
    }
}