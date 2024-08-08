<?php

namespace App\Middleware\Auth;

class User
{
    public function handle()
    {
        if (empty($_SESSION['user'])) {
            redirect(previousPage());
        }
    }
}