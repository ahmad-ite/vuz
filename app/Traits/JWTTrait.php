<?php

namespace App\Traits;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait JWTTrait
{

  private $jwtConfig;

  // load JWT configuration from file
  public function init()
  {
    $this->jwtConfig =   \F3::get('JWT'); //parse_ini_file('./../config/jwt.ini')['JWT'];
  }

  // create JWT token with given payload
  /* payload is associative array has
   * subscriptionId
   * msisdn
   * action= sub/unsub
   */
  public function createJWT($payload)
  {
    $this->init();

    $header = [
      'typ' => 'JWT',
      'alg' => $this->jwtConfig['jwt_algorithm']
    ];
    $payload = array_merge($payload, [
      'iss' => $this->jwtConfig['issuer'],
      'sub' => $this->jwtConfig['subject'],
      'aud' => $this->jwtConfig['audience'],
      'nbf' => time(),
      'iat' => time(),
      'exp' => time() + 3600, // expires in 1 hour
      'jti' => uniqid(),

    ]);

    $privateKey = openssl_get_privatekey(file_get_contents(__DIR__ . $this->jwtConfig['jwt_private_key_path']));

    $jwt = JWT::encode($payload, $privateKey, 'RS256', null, $header);

    return $jwt;
  }

  // validate JWT token
  public function validateJWT($jwt)
  {
    $this->init();
    $publicKey = openssl_get_publickey(file_get_contents(__DIR__ . $this->jwtConfig['jwt_public_key_path']));


    try {
      $decoded = JWT::decode($jwt, new Key($publicKey, 'RS256'));

      return $decoded;
    } catch (Exception $e) {
      return false;
    }
  }
}
