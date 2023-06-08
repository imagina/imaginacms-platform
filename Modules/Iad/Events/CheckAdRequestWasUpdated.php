<?php


namespace Modules\Iad\Events;

use Modules\Iad\Entities\Ad;

class CheckAdRequestWasUpdated
{
  public $request;
  public $action;

  public function __construct($request)
  {
    $this->action = 'updated';
    $this->request = $request;
  }
}
