<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class ServiceSubscriptionTypeRepository extends BaseRepository
{
    public function __construct($table = 'service_subscription_types')
    {
        parent::__construct($table);
    }
}