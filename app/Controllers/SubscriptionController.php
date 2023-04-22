<?php

namespace App\Controllers;


use App\Repositories\SubscriptionRepository;


class SubscriptionController
{

  public function subscribe()
  {
    $data = \F3::get('REQUEST');
    $repo = new \App\Repositories\SubscriptionRepository('users');

    return \App\View\API::success($repo->getAll());
  }
}