<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class PartnerServiceRepository extends BaseRepository
{
    public function __construct($table = 'partner_services')
    {
        parent::__construct($table);
    }
}