<?php

namespace Modules\Ibooking\Entities;

class Status
{
    const PENDING = 0;

    const APPROVED = 1;

    const CANCELED = 2;

    private $statuses = [];

    private $statuses2 = [];

    public function __construct()
    {
        $this->statuses = [
            self::PENDING => trans('ibooking::reservations.status.pending'),
            self::APPROVED => trans('ibooking::reservations.status.approved'),
            self::CANCELED => trans('ibooking::reservations.status.canceled'),
        ];
    }

    public function lists()
    {
        return $this->statuses;
    }

    public function convertToSettings()
    {
        $statuses = $this->statuses;
        $statusSetting = [];
        foreach ($statuses as $key => $status) {
            array_push($statusSetting, ['label' => $status, 'value' => $key]);
        }
        //\Log::info("StatusSetting: ".json_encode($statusSetting));
        return $statusSetting;
    }

    public function get($statusId)
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::PENDING];
    }
}
