<?php

namespace App\Requests;

use Respect\Validation\Validator as v;


class SubscribeRequestValidation extends RequestValidation
{

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'user_id' => v::notEmpty()->intVal(),
            'service_subscription_type_id' => v::notEmpty()->intVal(),
        ];
    }
}
