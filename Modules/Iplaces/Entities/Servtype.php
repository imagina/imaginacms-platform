<?php

namespace Modules\Iplaces\Entities;

class Servtype
{
    const PRINCIPAL = 0;
    const OTHERS = 1;


    /**
     * @var array
     */
    private $servtypes = [];

    public function __construct()
    {
        $this->servtypes = [
            self::PRINCIPAL => trans('iplaces::services.types.principal'),
            self::OTHERS => trans('iplaces::services.types.others'),

        ];
    }

    /**
     * Get the available statuses
     * @return array
     */
    /*listar*/
    public function lists()
    {
        return $this->servtypes;
    }

    /**
     * Get the post status
     * @param int $statusId
     * @return string
     */
    public function get($statusId)
    {
        if (isset($this->servtypes[$statusId])) {
            return $this->servtypes[$statusId];
        }

        return $this->servtypes[self::PRINCIPAL];
    }
}
