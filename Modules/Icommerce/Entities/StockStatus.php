<?php

namespace Modules\Icommerce\Entities;

/**
 * Class Status
 */
class StockStatus
{
    const OUTSTOCK = 0;

    const INSTOCK = 1;

    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::OUTSTOCK => trans('icommerce::stockStatus.outstock'),
            self::INSTOCK => trans('icommerce::stockStatus.instock'),
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

        return $this->statuses[self::OUTSTOCK];
    }
}
