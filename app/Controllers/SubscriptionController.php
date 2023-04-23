<?php

namespace App\Controllers;

use App\Traits\JWTTrait;
use App\Exceptions\Error;
use App\Traits\HTTPTrait;
use App\Repositories\UserRepository;
use App\Exceptions\NotFoundException;
use App\Exceptions\DuplicateException;
use Respect\Validation\Validator as v;
use App\Repositories\PartnerRepository;
use App\Exceptions\InvalidInputException;
use App\Requests\SubscribeRequestValidation;
use App\Repositories\PartnerServiceRepository;
use App\Requests\UnsubscribeRequestValidation;
use App\Repositories\SubscriptionRequestRepository;
use App\Repositories\ServiceSubscriptionTypeRepository;
// use \F3\Validation\Validator;

class SubscriptionController
{
  use JWTTrait, HTTPTrait;

  /**
   * SubscriptionRequestRepository
   */
  protected $subscriptionRequestRepository;

  /**
   * ServiceSubscriptionTypeRepository
   */
  protected $serviceSubscriptionTypeRepository;

  /**
   * PartnerServiceRepository
   */
  protected $partnerServiceRepository;

  /**
   * PartnerRepository
   */
  protected $partnerRepository;

  /**
   * UserRepository
   */
  protected $userRepository;

  public function __construct(
    SubscriptionRequestRepository $subscriptionRequestRepository,
    ServiceSubscriptionTypeRepository $serviceSubscriptionTypeRepository,
    PartnerServiceRepository $partnerServiceRepository,
    PartnerRepository $partnerRepository,
    UserRepository $userRepository,
  ) {
    $this->subscriptionRequestRepository = $subscriptionRequestRepository;
    $this->serviceSubscriptionTypeRepository = $serviceSubscriptionTypeRepository;
    $this->partnerServiceRepository = $partnerServiceRepository;
    $this->partnerRepository = $partnerRepository;
    $this->userRepository = $userRepository;
  }

  /**
   * Subscribe partner service 
   */
  public function subscribe()
  {
    //Fetch request data
    $data = \F3::get('REQUEST');
    // Input validation 
    $subscribeRequestValidation = new SubscribeRequestValidation();
    $subscribeRequestValidation->validate($data);


    // Get the service subscription type ID from the request
    $serviceSubscriptionTypeId = $data['service_subscription_type_id'];

    // Get the user ID from the request
    $userId = \F3::get('SESSION.user');

    // Get user
    $user = $this->userRepository->getById($userId);
    // If the user is not found, return a 404 error
    if (!$user) {
      throw new NotFoundException('user not found.');
    }

    // Get the service subscription type from the ServiceSubscriptionTypeRepository
    $serviceSubscriptionType = $this->serviceSubscriptionTypeRepository->getById($serviceSubscriptionTypeId);
    // If the service subscription type is not found, return a 404 error
    if (!$serviceSubscriptionType) {
      throw new NotFoundException('service subscription type not found.');
    }

    //validate previous active subscription
    $output = $this->subscriptionRequestRepository->getByWhere("user_id = $userId and service_subscription_type_id=$serviceSubscriptionTypeId and type ='" . SUB . "' and status=" . SUBSCRIBE);
    if ($output) {
      throw new DuplicateException('duplicate active  subscription.');
    }

    //Get partner service
    $partnerService = $this->partnerServiceRepository->getById($serviceSubscriptionType->partner_service_id);

    //Get partner 
    $partner = $this->partnerRepository->getById($partnerService->partner_id);


    //create subscription 
    $input = [
      "user_id" => $userId,
      "service_subscription_type_id" => $serviceSubscriptionTypeId,
      "status" => PENDING,
      "type" => SUB
    ];
    $subscriptionId = $this->subscriptionRequestRepository->add($input);

    // create JWT token with payload
    $payload = [
      'subscriptionId' => $subscriptionId,
      'msisdn' => $user->phone,
      'action' => 'sub',

      'email' => $user->email,
      'amount' => $serviceSubscriptionType->price,
      'currency' => $serviceSubscriptionType->currency,
    ];
    $jwt = $this->createJWT($payload);

    //send request to partner
    $url = $partner->host . 'subscribe/' . $jwt;
    $headers = array(
      "Authorization: Bearer $jwt",
      "Content-Type: application/json"
    );

    //send request
    if ($this->post($url, [], $headers)) {
      return \App\View\API::success(["result" => "ok"]);
    }
    return \App\View\API::success(["result" => "failure"]);
  }


  /**
   * Unsubscribe partner service 
   */
  public function unsubscribe()
  {
    //Fetch request data
    $data = \F3::get('REQUEST');

    // Input validation 
    $subscribeRequestValidation = new UnsubscribeRequestValidation();
    $subscribeRequestValidation->validate($data);


    // Get the subscription request ID from the request
    $subscriptionRequestId = $data['subscription_request_id'];

    // Get subscription Request
    $subscriptionRequest = $this->subscriptionRequestRepository->getById($subscriptionRequestId);
    // If the subscription Request is not found, return a 404 error
    if (!$subscriptionRequest) {
      throw new NotFoundException('subscription Request not found.');
    }

    //check subscription Request owner
    if ($subscriptionRequest->user_id != \F3::get('SESSION.user')) {
      throw new InvalidInputException('invalid subscription Request user');
    }

    //check subscription Request type && status
    if ($subscriptionRequest->type != SUB || $subscriptionRequest->status != SUBSCRIBE) {
      throw new InvalidInputException('invalid subscription Request');
    }

    // Get the service subscription type from the ServiceSubscriptionTypeRepository
    $serviceSubscriptionType = $this->serviceSubscriptionTypeRepository->getById($subscriptionRequest->service_subscription_type_id);

    //Get partner service
    $partnerService = $this->partnerServiceRepository->getById($serviceSubscriptionType->partner_service_id);

    //Get partner 
    $partner = $this->partnerRepository->getById($partnerService->partner_id);


    //create subscription 
    $input = [
      "user_id" => $subscriptionRequest->user_id,
      "service_subscription_type_id" => $subscriptionRequest->service_subscription_type_id,
      "status" => PENDING,
      "type" => UNSUB,
      "parent_subscription_request_id" => $subscriptionRequestId
    ];
    $subscriptionId = $this->subscriptionRequestRepository->add($input);

    // Get user
    $user = $this->userRepository->getById($subscriptionRequest->user_id);
    // create JWT token with payload
    $payload = [
      'subscriptionId' => $subscriptionId,
      'msisdn' => $user->phone,
      'action' => UNSUB,

      'email' => $user->email,
      'amount' => $serviceSubscriptionType->price,
      'currency' => $serviceSubscriptionType->currency,

    ];
    $jwt = $this->createJWT($payload);

    //send request to partner
    $url = $partner->host . 'unsubscribe/' . $jwt;
    $headers = array(
      "Authorization: Bearer $jwt",
      "Content-Type: application/json"
    );

    //send request
    if ($this->post($url, [], $headers)) {
      return \App\View\API::success(["result" => "ok"]);
    }
    return \App\View\API::success(["result" => "failure"]);
  }
}
