<?php

namespace Modules\Iprofile\Events;

use Illuminate\Queue\SerializesModels;

class UserUpdatedEvent
{
  use SerializesModels;
  public $user;

  public function __construct($user)
  {
    $this->user = $user;
  }
}
