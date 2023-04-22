<?php

use App\Controllers\SubscriptionController;


$subscriptionController = new SubscriptionController();
$f3->route('POST /api/subscribe', function () use ($subscriptionController) {
    $subscriptionController->subscribe();
});

$f3->route('POST /api/test', function ($f3) {
    echo 'This is a test route';
});