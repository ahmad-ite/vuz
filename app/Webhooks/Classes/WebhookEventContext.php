<?php

namespace App\Webhooks\Classes;

use App\Webhooks\Interfaces\WebhookEventHandler;



class WebhookEventContext
{
    private $strategy;

    public function __construct(WebhookEventHandler $strategy)
    {
        $this->strategy = $strategy;
    }

    public function handleEvent($webhook)
    {
        $this->strategy->handle($webhook);
    }
}
