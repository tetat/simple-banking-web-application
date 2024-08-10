<?php

namespace App\Core;

use App\Constants\ViewPath;
use Exception;

class CommonException extends Exception
{
    public readonly string $next;
    public readonly array $errors;
    public readonly array $old;

    public static function throw($errors, $old = [], $path = ViewPath::HOME)
    {
       $instance = new static('Error occurred!');

       $instance->next = $path;
       $instance->errors = $errors;
       $instance->old = $old;

       throw $instance;
    }
}