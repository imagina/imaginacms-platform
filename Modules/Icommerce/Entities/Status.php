<?php

namespace Modules\Icommerce\Entities;

/**
 * Class Status
 */
class Status
{
    const DISABLED = 0;

    const ENABLED = 1;

    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::DISABLED => trans('icommerce::status.disabled'),
            self::ENABLED => trans('icommerce::status.enabled'),
        ];
    }

    /**
     * Get the available statuses
     */
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

        return $this->statuses[self::DISABLED];
    }
}
