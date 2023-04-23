<?php

namespace App\Requests;

use Respect\Validation\Validator as v;


class UnsubscribeRequestValidation extends RequestValidation
{

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'subscription_request_id' => v::notEmpty()->intVal(),
        ];
    }
}
