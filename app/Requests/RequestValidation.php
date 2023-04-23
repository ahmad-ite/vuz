<?php

namespace App\Requests;


use Respect\Validation\Validator as v;
use App\Exceptions\InvalidInputException;


class RequestValidation
{

    protected $rules = [];

    // public function __construct($rules)
    // {
    //     $this->rules = $rules;
    // }
    /**
     * validate data 
     *  @param [] $data assoisative array
     *  @throws InvalidInputException|boolean
     */
    public function validate($data = [])
    {

        try {

            if (!count($this->rules)) return true;
            $keySetArgs = [];

            foreach ($this->rules as $key => $rule) {
                $keySetArgs[] = v::key($key, $rule);
            }
            $validation = v::arrayVal()->keySet(...$keySetArgs);
            return  $validation->assert($data);
            return true;
        } catch (\Throwable $th) {
            throw new InvalidInputException("Invalid Input", $th->getMessage());
        }
    }
}