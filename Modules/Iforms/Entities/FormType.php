<?php

namespace Modules\Iforms\Entities;

use Illuminate\Database\Eloquent\Model;

class FormType extends Model
{
    const NORMAL = 1;

    const STEPS = 2;

    /**
     * @var array
     */
    private $types = [];

    public function __construct()
    {
        $this->types = [
            [
                'id' => self::NORMAL,
                'name' => trans('iforms::common.formTypes.normal'),
                'value' => 'normal',
            ],
            [
                'id' => self::STEPS,
                'name' => trans('iforms::common.formTypes.steps'),
                'value' => 'steps',
            ],
        ];
    }

    /**
     * Get the available statuses
     */
    public function lists()
    {
        return $this->types;
    }

    /**
     * Get the post status
     */
    public function get($id)
    {
        $id--;
        if (isset($this->types[$id])) {
            return $this->types[$id];
        }

        return $this->types[0];
    }
}
