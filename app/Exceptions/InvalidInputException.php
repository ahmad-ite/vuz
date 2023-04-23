<?php

namespace App\Exceptions;

use App\Exceptions\Error;

class InvalidInputException extends Error
{


    public function __construct(
        $description = "Invalid Input",
        $error_code = 400,
        $title = "Invalid Input",
        $reason = "Invalid Input",
        $http_code = 400,
        ErrorModel $prevErrorModel = null,
        \Throwable $exception = null
    ) {

        parent::__construct($description,   $error_code, $title, $reason,  $http_code, $prevErrorModel, $exception);
        $this->title = $title;
        $this->description = $description;
        $this->reason = $reason;
        $this->error_code = $error_code;
        $this->prevErrorModel = $prevErrorModel;
        $this->exception = $exception;
        $this->http_code = $http_code;
    }
}
