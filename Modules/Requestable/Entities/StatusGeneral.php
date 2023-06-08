<?php

namespace Modules\Requestable\Entities;


class StatusGeneral
{
    const INACTIVE = 0;
    const ACTIVE = 1;
   
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::INACTIVE => trans('requestable::common.statusGeneral.inactive'),
            self::ACTIVE => trans('requestable::common.statusGeneral.active'),
        ];
    }

    public function lists()
    {
        return $this->statuses;
    }

    public function getAllStatus()
    {

        $statuses = $this->statuses;
        $statusTransform = [];
        foreach ($statuses as $key => $status) {
           array_push($statusTransform,['value' => $key, 'name' => $status]);
        }
        //\Log::info("StatusSetting: ".json_encode($statusSetting));
        //return $statusTransform;
        return collect($statusTransform);

    }

   
    public function get($statusId)
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::ACTIVE];
    }
    
}
