<?php

namespace Modules\Ihelpers\Events;

use Modules\Media\Contracts\StoringMedia;

class UpdateMedia implements StoringMedia
{
  public $data;
  public $post;

  public function __construct($post, array $data)
  {
    $this->post = $post;
    $this->data = $data;
  }

  /**
   * Return the entity
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function getEntity()
  {
    return $this->post;
  }

  /**
   * Return the ALL data sent
   * @return array
   */
  public function getSubmissionData()
  {
    return $this->data;
  }
}
