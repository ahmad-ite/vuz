<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class SubscriptionRepository extends BaseRepository
{
    public function __construct($table = 'subscription_requests')
    {
        parent::__construct($table);
    }

    public function addSubscription($data)
    {

        return true;
    }
}