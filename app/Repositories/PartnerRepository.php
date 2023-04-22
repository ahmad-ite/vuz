<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class PartnerRepository extends BaseRepository
{
    public function __construct($table = 'partners')
    {
        parent::__construct($table);
    }
}