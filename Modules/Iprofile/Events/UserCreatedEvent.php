<?php

namespace Modules\Iprofile\Events;

use Illuminate\Queue\SerializesModels;

class UserCreatedEvent
{
  use SerializesModels;
  public $user;
  public $bindings;

  public function __construct($user, $bindings)
  {
   
    $this->user = $user;
    $this->bindings = $bindings;

  }
}
