<?php

namespace Modules\Icommerce\Events;

use Illuminate\Database\Eloquent\Model;

class CouponIsDeleting
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
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
        return [];
    }
}
