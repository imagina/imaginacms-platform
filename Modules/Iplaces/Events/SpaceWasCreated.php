<?php


namespace Modules\Iplaces\Events;

use Modules\Iplaces\Entities\Space;
use Modules\Media\Contracts\StoringMedia;

class SpaceWasCreated implements StoringMedia
{
    public $entity;
    public  $data;

    /**
     * Create a new event instance.
     *
     * @param $entity
     * @param array $data
     */
    public function __construct($entity,array $data)
    {// dd($data,$entity);
        $this->data=$data;
        $this->entity=$entity;
    }

    public function getEntity()
    {
        return $this->entity;
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