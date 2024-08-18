<?php

namespace App\Controllers;

use App\Core\Session;

class HomeController
{
    public function home()
    {
        // dd(Session::get('user'));
        return view("home", [
            'title' => "Bangubank",
            'user' => Session::get('user', []),
            'errors' => Session::get('errors')
        ]);
    }
}