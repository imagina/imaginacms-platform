<?php

namespace Modules\Requestable\Entities;

/**
 * Class Status
 */
class DefaultStatus
{
    const PENDING = 1;

    const INPROGRESS = 2;

    const COMPLETED = 3;

    const CANCELLED = 4;

    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::PENDING => [
                'id' => self::PENDING,
                'default' => true,
                'title' => trans('requestable::common.status.pending'),

            ],
            self::INPROGRESS => [
                'id' => self::INPROGRESS,
                'title' => trans('requestable::common.status.inProgress'),
            ],
            self::COMPLETED => [
                'id' => self::COMPLETED,
                'final' => true,
                'title' => trans('requestable::common.status.completed'),

            ],
            self::CANCELLED => [
                'id' => self::CANCELLED,
                'final' => true,
                'title' => trans('requestable::common.status.cancelled'),
            ],
        ];
    }

    /**
     * Get the available statuses
     *
     * @return array
     */
    public function lists()
    {
        return $this->statuses;
    }

    /**
     * Get the request status
     *
     * @param  int  $statusId
     * @return string
     */
    public function get($statusId)
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::PENDING];
    }
}
