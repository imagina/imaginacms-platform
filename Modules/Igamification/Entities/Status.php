<?php

namespace Modules\Igamification\Entities;

class Status
{
    const INACTIVE = 0;

    const ACTIVE = 1;

    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::INACTIVE => trans('igamification::activities.status.inactive'),
            self::ACTIVE => trans('igamification::activities.status.active'),
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
