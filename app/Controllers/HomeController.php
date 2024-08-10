<?php

namespace App\Controllers;

use App\Core\Session;

class HomeController
{
    public function home()
    {
        return view("home", [
            'title' => "Bangubank",
            'errors' => Session::get('errors')
        ]);
    }
}