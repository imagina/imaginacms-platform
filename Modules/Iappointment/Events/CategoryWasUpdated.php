<?php

namespace Modules\Iappointment\Events;

class CategoryWasUpdated
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
     *
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
