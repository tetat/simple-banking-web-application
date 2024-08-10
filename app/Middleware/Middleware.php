<?php

namespace App\Middleware;

use App\Core\CommonException;

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
            CommonException::throw(
                [
                    'alert' => ["middleware" => "No matching middleware found for key {$key}"],
                ],
                [],
                previousPage()
            );
        }

        (new $middleware)->handle();
    }
}