<?php

namespace Modules\Iplaces\Events;

use Modules\Media\Contracts\StoringMedia;

class ServiceWasCreated implements StoringMedia
{
    public $entity;

    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct($entity, array $data)
    {// dd($data,$entity);
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
