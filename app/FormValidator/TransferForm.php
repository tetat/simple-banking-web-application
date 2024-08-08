<?php

namespace App\FormValidator;

use App\Core\Validator;
use App\Core\ValidationException;

class TransferForm
{
    protected $errors = [];

    public function __construct(public array $attributes)
    {
        if (!Validator::isEmail($attributes['email'])) {
            $this->errors['email'] = 'Please provide reciever\'s email address.';
        }

        if (!Validator::isNumber($attributes['amount'], 0)) {
            $this->errors['amount'] = 'Please provide a valid amount greater than zero.';
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
}