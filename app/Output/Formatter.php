<?php

namespace App\Output;

class Formatter extends \Prefab
{
    public function format_success($data)
    {
        return [
            "status" => true,
            "data" => $data,
            "error" => null
        ];
    }

    public function format_error(\App\Exceptions\Error $data)
    {
        return [
            "status" => false,
            "data" => null,
            "error" => $data->serve_exception()
        ];
    }
}
