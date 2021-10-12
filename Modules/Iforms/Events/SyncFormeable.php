<?php

namespace Modules\Iforms\Events;


class SyncFormeable
{
  
  
  public $entity;
  public $data;
  
  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($entity, array $data)
  {
    $this->data = $data;
    $this->entity = $entity;
  }
  
}
