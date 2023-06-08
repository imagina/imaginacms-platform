<?php

namespace Modules\Igamification\Events;

class CategoryWasCompleted
{

  public $params;

  public function __construct($params = null)
  {
    $this->params = $params;
  }

}
