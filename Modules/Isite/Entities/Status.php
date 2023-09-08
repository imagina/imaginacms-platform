<?php

namespace Modules\Isite\Entities;


class Status
{
    const INACTIVE = 0;
    const ACTIVE = 1;

    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
             self::INACTIVE => trans('isite::organizations.status.inactive'),
            self::ACTIVE => trans('isite::organizations.status.active')
        ];
    }

    public function lists()
    {
        return $this->statuses;
    }


    public function get($statusId)
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::INACTIVE];
    }

}
