<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class SubscriptionRequestRepository extends BaseRepository
{
    public function __construct($table = 'subscription_requests')
    {
        parent::__construct($table);
    }
}