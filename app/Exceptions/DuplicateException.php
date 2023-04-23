<?php

namespace App\Exceptions;

use App\Exceptions\Error;

class DuplicateException extends Error
{


    public function __construct(
        $description = "Duplicate Exception",
        $error_code = 409,
        $title = "Duplicate Exception",
        $reason = "Duplicate Input",
        $http_code = 409,
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
