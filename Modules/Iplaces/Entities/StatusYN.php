<?php

namespace Modules\Iplaces\Entities;

class StatusYN
{
    const NO = 0;

    const YES = 1;

    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::NO => trans('iplaces::statusyn.no'),
            self::YES => trans('iplaces::statusyn.yes'),

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

        return $this->statuses[self::NO];
    }
}
