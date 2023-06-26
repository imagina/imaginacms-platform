<?php

namespace Modules\Icommerce\Events;

use Illuminate\Database\Eloquent\Model;

class DeleteProductable
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Return the entity
     */
    public function getEntity(): Model
    {
        return $this->model;
    }

    /**
     * Return the ALL data sent
     */
    public function getSubmissionData(): array
    {
        return [];
    }
}
