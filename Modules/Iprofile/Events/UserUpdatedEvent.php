<?php

namespace Modules\Iprofile\Events;

use Illuminate\Queue\SerializesModels;

class UserUpdatedEvent
{
  use SerializesModels;
  public $user;

  public function __construct($user,$bindings)
  {
    $this->user = $user;
    $this->bindings = $bindings;
  }
}
