<?php

namespace Modules\Iprofile\Events;

use Illuminate\Queue\SerializesModels;

class ImpersonateEvent
{
  use SerializesModels;
  public $userIdImpersonate;
  public $ip;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userIdImpersonate, $ip)
    {
      $this->userIdImpersonate = $userIdImpersonate;
      $this->ip = $ip;
    }
}
