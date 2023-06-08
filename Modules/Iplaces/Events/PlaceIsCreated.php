<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 3/10/2018
 * Time: 5:41 PM
 */

namespace Modules\Iplaces\Events;

use Modules\Iplaces\Entities\Place;
use Modules\Core\Events\AbstractEntityHook;


class PlaceIsCreated extends AbstractEntityHook
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





}