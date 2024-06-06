<?php

namespace Modules\Iprofile\Events;

use Illuminate\Queue\SerializesModels;

class UserCreatedEvent
{
  use SerializesModels;
  public $user;

  public function __construct($user)
  {
    $this->user = $user;
  }
}
