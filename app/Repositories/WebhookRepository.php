<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class WebhookRepository extends BaseRepository
{
    public function __construct($table = 'webhooks')
    {
        parent::__construct($table);
    }
}
