<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct($table = 'users')
    {
        parent::__construct($table);
    }
}