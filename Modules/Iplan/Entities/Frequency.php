<?php

namespace Modules\Iplan\Entities;

/**
 * Class Status
 */
class Frequency
{
    const UNIQUE = 0;

    const DIARY = 1;

    const WEEKLY = 8;

    const BIWEEKLY = 15;

    const MONTHLY = 30;

    const BIMONTHLY = 60;

    const QUARTERLY = 90;

    const BIANNUAL = 180;

    const ANNUAL = 365;

    /**
     * @var array
     */
    private $frequencies = [];

    public function __construct()
    {
        $this->frequencies = [
            ['id' => self::UNIQUE, 'title' => trans('iplan::plans.frequencies.unique')],
            ['id' => self::DIARY, 'title' => trans('iplan::plans.frequencies.diary')],
            ['id' => self::BIWEEKLY, 'title' => trans('iplan::plans.frequencies.biweekly')],
            ['id' => self::MONTHLY, 'title' => trans('iplan::plans.frequencies.monthly')],
            ['id' => self::BIMONTHLY, 'title' => trans('iplan::plans.frequencies.bimonthly')],
            ['id' => self::QUARTERLY, 'title' => trans('iplan::plans.frequencies.quarterly')],
            ['id' => self::BIANNUAL, 'title' => trans('iplan::plans.frequencies.biannual')],
            ['id' => self::ANNUAL, 'title' => trans('iplan::plans.frequencies.annual')],
        ];
    }

    /**
     * Get the available statuses
     */
    public function lists()
    {
        return $this->frequencies;
    }

    /**
     * Get the post status
     *
     * @param  int  $statusId
     */
    public function get($frequencyId)
    {
        $frequencies = collect($this->frequencies);
        $frequency = $frequencies->where('id', $frequencyId)->first() ?? $frequencies->where('id', self::MONTHLY)->first();

        return $frequency['title'];
    }
}
