<?php

namespace Modules\Icommerce\Events;

use Illuminate\Database\Eloquent\Model;

class CouponWasUpdated
{
    public $model;

    public $data;

    public function __construct($model, array $data)
    {
        $this->model = $model;
        $this->data = $data;
    }

    /**
     * Return the entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity(): Model
    {
        return $this->model;
    }

    /**
     * Return the ALL data sent
     *
     * @return array
     */
    public function getSubmissionData(): array
    {
        return $this->data;
    }
}
