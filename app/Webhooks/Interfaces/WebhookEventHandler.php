<?php

namespace App\Webhooks\Interfaces;

interface WebhookEventHandler
{
    public function handle($webhook);
}