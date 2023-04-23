<?php

namespace App\Webhooks\Classes;

use App\Exceptions\NotFoundException;
use App\Exceptions\DuplicateException;
use App\Exceptions\InvalidInputException;
use App\Webhooks\Interfaces\WebhookEventHandler;

class SubscribeEventHandler implements WebhookEventHandler
{

    /**
     * validate data 
     *  @webhook data 
     *  @throws Exception|boolean
     */
    public function handle($webhook)
    {
        //define Subscription Request Repository 
        $subscriptionRequestRepository = new \App\Repositories\SubscriptionRequestRepository();

        //Get Subscription Request 
        $subscriptionRequest = $subscriptionRequestRepository->getById($webhook->subscription_id);
        // If the subscription request is not found, return a 404 error
        if (!$subscriptionRequest) {
            throw new NotFoundException('subscription request not found.');
        }
        //check subscription Request type && status
        if ($subscriptionRequest->type != SUB || $subscriptionRequest->status != PENDING) {
            throw new InvalidInputException('invalid subscription Request');
        }



        // Handle subscribe event
        if ($webhook->event == 'subscription.succeed') {
            //validate previous active subscription
            $output = $subscriptionRequestRepository->getByWhere("user_id = $subscriptionRequest->user_id  and service_subscription_type_id=$subscriptionRequest->service_subscription_type_id  and type ='" . SUB . "' and status=" . SUBSCRIBE);
            if ($output) {
                throw new DuplicateException('duplicate active  subscription.');
            }

            $subscriptionRequestRepository->update($subscriptionRequest->id, ['status' => SUBSCRIBE]);
        } else if ($webhook->event == 'subscription.failed') {
            $subscriptionRequestRepository->update($subscriptionRequest->id, ['status' => REJECED]);
        }
        return true;
    }
}
