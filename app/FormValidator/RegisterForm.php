<?php

namespace App\FormValidator;

use App\Core\Validator;
use App\Core\ValidationException;

class RegisterForm
{
    protected $errors = [];
    protected $success = [];

    public function __construct(public array $attributes)
    {
        if (!Validator::isString($attributes['name'], 3, 50)) {
            $this->errors['name'] = 'Please provide a valid name.';
        }

        if (!Validator::isEmail($attributes['email'])) {
            $this->errors['email'] = 'Please provide a valid email address.';
        }

        if (!Validator::isString($attributes['password'], 8, 20)) {
            $this->errors['password'] = 'Password should be valid.';
        }

        if (!Validator::isString($attributes['password2'], 8, 20)) {
            $this->errors['password2'] = 'Confirm password should be valid.';
        }

        if (!isset($this->errors['password']) and !isset($this->errors['password2']) ) {
            if ($attributes['password'] !== $attributes['password2']) {
                $this->errors['password2'] = 'Confirm password did not matched.';
            }
        }
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);

        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function throw()
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }

    public function failed()
    {
        return count($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($field, $message)
    {
        $this->errors[$field] = $message;

        return $this;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function putSuccess($field, $message)
    {
        $this->success[$field] = $message;

        return $this;
    }
}