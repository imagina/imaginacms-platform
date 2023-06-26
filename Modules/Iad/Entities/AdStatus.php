<?php

namespace Modules\Iad\Entities;

/**
 * Class Status
 */
class AdStatus
{
    const DISABLED = 0;

    const PENDING = 1;

    const PUBLISHED = 2;

    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            ['id' => self::DISABLED, 'name' => trans('iad::status.disabled')],
            ['id' => self::PENDING, 'name' => trans('iad::status.pending')],
            ['id' => self::PUBLISHED, 'name' => trans('iad::status.published')],
        ];
    }

    /**
     * Get the available statuses
     */
    public function get(): array
    {
        return $this->statuses;
    }
}
