<?php

namespace App\Middlewares;

use App\Traits\JWTTrait;

class Auth
{
    use JWTTrait;
    function auth($f3)
    {

        // Check if API request includes an auth token
        $authToken = $f3->get('HEADERS.Authorization');
        if (!$authToken) {
            // Return error response if no auth token found
            $f3->error(401, 'Unauthorized');
        }

        $authToken = str_replace("Bearer ", "", $authToken);
        // Check if auth token is valid
        if (!$payload = $this->validateJWT($authToken)) {
            // Return error response if auth token is invalid
            $f3->error(401, 'Unauthorized');
        }
        $f3->set('SESSION.user', $payload->user_id);
    }
}