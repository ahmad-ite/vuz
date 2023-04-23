<?php

namespace App\Controllers;


use Hash;
use App\Traits\JWTTrait;
use App\Repositories\UserRepository;
use App\Requests\LoginRequestValidation;

class LoginController
{
  use JWTTrait;

  /**
   * UserRepository
   */
  protected $userRepository;

  public function __construct(
    UserRepository $userRepository
  ) {
    $this->userRepository = $userRepository;
  }

  /**
   * Subscribe partner service 
   */
  public function login()
  {

    //Fetch request data
    $data = \F3::get('REQUEST');

    // Input validation 
    $loginRequestValidation = new LoginRequestValidation();
    $loginRequestValidation->validate($data);

    //Get login inputs
    $email = $data['email'];
    $pass = $data['password'];


    //check user via email
    $user = $this->userRepository->getByWhere("email='$email'");
    if (!$user) return  \App\View\API::error("email not found");;

    $user = $user[0];
    //check user pass
    if (password_verify($pass, $user['password'])) {
      // Generate API authentication token
      $payload = [
        'email' => $email,
        'user_id' => $user['id'],
        'exp' => time() + 3600, // Expires in 1 hour
      ];
      $token = $this->createJWT($payload);
      return \App\View\API::success(["token" =>   $token]);
    }
    return  \App\View\API::error("Invalid password");;
  }
}
