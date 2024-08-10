<?php

namespace App\FormValidator;

use App\Core\Validator;
use App\Core\CommonException;

class LoginForm extends Form
{
    public function __construct(public array $attributes)
    {
        if (!Validator::isEmail($attributes['email'])) {
            $this->errors['email'] = 'Please provide your email address.';
        }

        if (!Validator::isString($attributes['password'])) {
            $this->errors['password'] = 'Please provide your password.';
        }
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);

        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function throw()
    {
        CommonException::throw($this->errors(), $this->attributes, previousPage());
    }
}