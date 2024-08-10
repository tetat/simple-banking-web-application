<?php

namespace App\Core;

class Validator
{
    public static function isString($value, $min = 1, $max = INF): bool
    {
        $value = senitize($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function isEmail(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function isNumber($value, $min = 1, $max = INF): bool
    {
        $amount = trim($value);

        if (strlen($amount) < strlen($value))return false;
        if (!is_numeric($amount)) return false;
        if ($amount <= $min or $amount > $max) return false;

        return true;
    }
}