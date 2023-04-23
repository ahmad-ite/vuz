<?php

namespace App\Webhooks\Classes;

use App\Exceptions\NotFoundException;
use App\Exceptions\DuplicateException;
use App\Exceptions\InvalidInputException;
use App\Webhooks\Interfaces\WebhookEventHandler;

class UnsubscribeEventHandler implements WebhookEventHandler
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
        if ($subscriptionRequest->type != UNSUB || $subscriptionRequest->status != PENDING) {
            throw new InvalidInputException('invalid subscription Request');
        }



        // Handle unsubscribe event
        if ($webhook->event == 'unsubscription.succeed') {
            // Get active subscribed request
            $activeSubscriptionRequest = $subscriptionRequestRepository->getById($subscriptionRequest->parent_subscription_request_id);
            // If the active subscription request is not found, return a 404 error
            if (!$activeSubscriptionRequest || $activeSubscriptionRequest->status != SUBSCRIBE) {
                throw new DuplicateException('duplicate event.');
            }

            //update active subscription request
            $subscriptionRequestRepository->update($activeSubscriptionRequest->id, ['status' => UNSUBSCRIBE]);

            //update current subscription request
            $subscriptionRequestRepository->update($subscriptionRequest->id, ['status' => UNSUBSCRIBE]);
        } else if ($webhook->event == 'unsubscription.failed') {
            $subscriptionRequestRepository->update($subscriptionRequest->id, ['status' => REJECED]);
        }
        return true;
    }
}
