<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 3/10/2018
 * Time: 5:41 PM
 */

namespace Modules\Iplaces\Events;

use Modules\Media\Contracts\StoringMedia;

class PlaceWasCreated implements StoringMedia
{
    public $entity;

    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct($entity, array $data)
    {
        $this->data = $data;
        $this->entity = $entity;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Return the ALL data sent
     */
    public function getSubmissionData(): array
    {
        return $this->data;
    }
}
