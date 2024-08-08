<?php

namespace App\Middleware;

use App\Middleware\Auth\User;
use App\Middleware\Auth\Admin;
use App\Middleware\Auth\Customer;

class Middleware
{
    public const MAP = [
        'guest' => Guest::class,
        'user' => User::class,
        'customer' => Customer::class,
        'admin' => Admin::class
    ];

    public static function resolve($key)
    {
        if (! $key) return;

        $middleware = static::MAP[$key] ?? null;

        if (! $middleware) {
            // throw new Exception("No matching middleware found for key {$key}");
        }

        (new $middleware)->handle();
    }
}