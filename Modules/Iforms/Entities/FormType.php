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
     *
     * @return array
     */
    public function lists(): array
    {
        return $this->types;
    }

    /**
     * Get the post status
     *
     * @param  int  $id
     * @return string
     */
    public function get(int $id): string
    {
        $id--;
        if (isset($this->types[$id])) {
            return $this->types[$id];
        }

        return $this->types[0];
    }
}
