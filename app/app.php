<?php


require_once('vendor/autoload.php');

\F3::instance()->set('ONERROR', function ($f3) {
    if ($f3->exists('EXCEPTION') && $f3->get('EXCEPTION') instanceof \App\Exceptions\Error) {
        $excp = $f3->get('EXCEPTION');
        $f3->status($excp->get_http_status());
        return \App\View\API::error($excp);
    }

    // echo 2222;
    // echo   $f3->get('ERROR.text');
    $error = new \App\Exceptions\Error(
        $f3->get('ERROR.status'),
        $f3->get('ERROR.text'),
        "HTTP" . $f3->get('ERROR.code'),
        null,
        $f3->get('ERROR.code'),
        null,
        $f3->get('EXCEPTION')
    );

    return \App\View\API::error($error);
});