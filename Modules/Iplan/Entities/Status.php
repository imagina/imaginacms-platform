<?php

namespace Modules\Iplan\Entities;

class Status
{
    const INACTIVE = 0;

    const ACTIVE = 1;

    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::INACTIVE => trans('iplan::subscriptions.status.inactive'),
            self::ACTIVE => trans('iplan::subscriptions.status.active'),
        ];
    }

    public function lists()
    {
        return $this->statuses;
    }

    public function get($statusId)
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::INACTIVE];
    }

    public function index()
    {
        //Instance response
        $response = [];
        //AMp status
        foreach ($this->statuses as $key => $status) {
            array_push($response, ['id' => $key, 'title' => $status]);
        }
        //Repsonse
        return collect($response);
    }
}
