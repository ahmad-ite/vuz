<?php

namespace App\Exceptions;

use App\Exceptions\Error;

class NotFoundException extends Error
{


    public function __construct(
        $description = "resource is not found",
        $error_code = "",
        $title = 'Not Found',
        $reason = "resource is not found",
        $http_code = 404,
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