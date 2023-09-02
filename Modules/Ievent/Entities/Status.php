<?php

namespace Modules\Ievent\Entities;

/**
 * Class Status
 */
class Status
{
    const PUBLISHED = 1;

    const CANCELLED = 0;

    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::PUBLISHED => trans('ievent::common.status.published'),
            self::CANCELLED => trans('ievent::common.status.cancelled'),
        ];
    }

    /**
     * Get the available statuses
     */
    public function lists()
    {
        return $this->statuses;
    }

    /**
     * Get the post status
     */
    public function get($statusId)
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::PUBLISHED];
    }
}
