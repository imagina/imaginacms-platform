<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 3/10/2018
 * Time: 5:41 PM
 */

namespace Modules\Iplaces\Events;

use Modules\Iplaces\Entities\Place;
use Modules\Media\Contracts\StoringMedia;


class PlaceWasCreated implements StoringMedia
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
    {
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