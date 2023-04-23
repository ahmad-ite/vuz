<?php

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
$f3->route('POST /api/subscribe', function () use ($subscriptionController) {
    $subscriptionController->subscribe();
});

$f3->route('POST /api/unsubscribe', function () use ($subscriptionController) {
    $subscriptionController->unsubscribe();
});


$f3->route('POST /api/webhook', function () use ($webhookController) {
    $webhookController->handle();
});
