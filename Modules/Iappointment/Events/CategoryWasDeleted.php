<?php

namespace Modules\Iappointment\Events;

class CategoryWasDeleted
{
    public $entity;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param  array  $data
     */
    public function __construct($entity)
    {
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
        return [];
    }
}
