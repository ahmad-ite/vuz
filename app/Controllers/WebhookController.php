<?php

namespace App\Controllers;

use App\Repositories\WebhookRepository;
use App\Webhooks\Classes\WebhookEventContext;
use App\Webhooks\Classes\SubscribeEventHandler;
use App\Webhooks\Classes\UnsubscribeEventHandler;
use App\Repositories\SubscriptionRequestRepository;

class WebhookController
{

  /**
   * WebhookRepository
   */
  protected $webhookRepository;

  /**
   * SubscriptionRequestRepository
   */
  protected $subscriptionRequestRepository;




  public function __construct(
    WebhookRepository $webhookRepository,
    SubscriptionRequestRepository $subscriptionRequestRepository

  ) {
    $this->webhookRepository = $webhookRepository;
    $this->subscriptionRequestRepository = $subscriptionRequestRepository;
  }

  /**
   * Subscribe partner service 
   */
  public function handle()
  {
    //Fetch request data
    $payload = \F3::get('BODY');
    $payload = json_decode($payload);

    //TODO validate webhook resourse by signature

    //create webhook log 
    $input = [
      "event" => $payload->event,
      "action" => $payload->data->action,
      "referenc_id" => $payload->data->id,
      "subscription_id" => $payload->data->subscriptionId,
      // "partner_id" => null, //fetch by webhook provider 
      "amount" => $payload->data->amount ?? null,
      "currency" =>  $payload->data->currency ?? null,
      "email" =>  $payload->data->email ?? null,
      "error" =>  $payload->data->error ?? null,
      "description" =>  $payload->data->description ?? null,
      "payload" => json_encode('{}') // adding extral attributes here
    ];
    $webhookId = $this->webhookRepository->add($input);

    //Get webhook object
    $webhook = $this->webhookRepository->getById($webhookId);


    //Handle Webhook Event
    $handler = null;
    if ($webhook->action == SUB) {
      $handler = new WebhookEventContext(new SubscribeEventHandler());
    } else if ($webhook->action == UNSUB) {
      $handler = new WebhookEventContext(new UnsubscribeEventHandler());
    }


    $handler?->handleEvent($webhook);

    return \App\View\API::success(["result" => "ok"]);
  }
}
