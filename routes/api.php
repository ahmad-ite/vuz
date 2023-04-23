<?php

use App\Traits\JWTTrait;
use App\Middlewares\Auth;
use App\Controllers\LoginController;
use App\Controllers\WebhookController;
use App\Controllers\SubscriptionController;

$subscriptionRequestRepository = new \App\Repositories\SubscriptionRequestRepository();
$serviceSubscriptionTypeRepository = new \App\Repositories\ServiceSubscriptionTypeRepository();
$partnerServiceRepository = new \App\Repositories\PartnerServiceRepository();
$partnerRepository = new \App\Repositories\PartnerRepository();
$userRepository = new \App\Repositories\UserRepository();
$webhookRepository = new \App\Repositories\WebhookRepository();


$subscriptionController = new SubscriptionController($subscriptionRequestRepository, $serviceSubscriptionTypeRepository, $partnerServiceRepository, $partnerRepository, $userRepository);
$webhookController = new WebhookController($webhookRepository, $subscriptionRequestRepository);
$loginController = new LoginController($userRepository);

$f3->route('POST /api/login', function () use ($loginController) {
    $loginController->login();
});


$f3->route('POST /api/subscribe', function ($f3) use ($subscriptionController) {

    (new Auth())->auth($f3);
    $subscriptionController->subscribe();
});

$f3->route('POST /api/unsubscribe', function ($f3) use ($subscriptionController) {
    (new Auth())->auth($f3);
    $subscriptionController->unsubscribe();
});


$f3->route('POST /api/webhook', function () use ($webhookController) {
    $webhookController->handle();
});
