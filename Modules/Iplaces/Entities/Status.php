<?php

namespace Modules\Iplaces\Entities;

class Status
{
    const INACTIVE = 0;

    const ACTIVE = 1;

    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::INACTIVE => trans('iplaces::status.inactive'),
            self::ACTIVE => trans('iplaces::status.active'),

        ];
    }

    /**
     * Get the available statuses
     */
    /*listar*/
    public function lists(): array
    {
        return $this->statuses;
    }

    /**
     * Get the post status
     */
    public function get(int $statusId): string
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::INACTIVE];
    }
}
