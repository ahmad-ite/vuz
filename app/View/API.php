<?php

namespace App\View;

class API
{
    public static function error($data, $http_code = 400, $desc = null)
    {
        if (!($data instanceof \App\Exceptions\Error)) {
            $data = new \App\Exceptions\Error(
                $data,
                $desc,
                "HTTP" . $http_code,
                null,
                $http_code,
                null,
                null
            );
        }
        return self::serve(\App\Output\Formatter::instance()->format_error($data));
    }

    public static function success($data)
    {
        return self::serve(\App\Output\Formatter::instance()->format_success($data));
    }

    protected static function serve($data)
    {

        $f3 = \F3::instance();
        if (!isset($f3->PARAMS['extension']))
            return   \App\Output\JSON::instance()->serve($data);;
        if ((strtolower($f3->PARAMS['extension']) == 'json' || $f3->PARAMS['extension'] == '')) {
            \App\Output\JSON::instance()->serve($data);
        } else if (strtolower($f3->PARAMS['extension']) == 'xml') {
            \App\Output\XML::instance()->serve($data);
        } else {
            \App\Output\Plain::instance()->serve($data);
        }
    }
}
