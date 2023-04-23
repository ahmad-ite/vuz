<?php

namespace App\Requests;

use Respect\Validation\Validator as v;


class LoginRequestValidation extends RequestValidation
{

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'email' => v::notEmpty()->stringVal(),
            'password' => v::notEmpty()->stringVal(),
        ];
    }
}
