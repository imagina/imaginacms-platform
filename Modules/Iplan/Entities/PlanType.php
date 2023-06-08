<?php

namespace Modules\Iplan\Entities;


class PlanType
{
    const PRINCIPAL = 0;
    const EXTRA = 1;

    private $types = [];

    public function __construct()
    {
        $this->types = [
            self::PRINCIPAL => trans('iplan::plans.types.principal'),
            self::EXTRA => trans('iplan::plans.types.extra')
        ];
    }

    public function lists()
    {
        return $this->types;
    }


    public function get($statusId)
    {
        if (isset($this->types[$statusId])) {
            return $this->types[$statusId];
        }

        return $this->types[self::PRINCIPAL];
    }

    public function index()
    {
        //Instance response
        $response = [];
        //AMp status
        foreach ($this->types as $key => $status) {
          array_push($response, ['id' => $key, 'title' => $status]);
        }
        //Repsonse
        return collect($response);
    }
    
}