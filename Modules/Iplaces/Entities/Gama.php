<?php

namespace Modules\Iplaces\Entities;


class Gama
{
    const EXCLUSIVE = 0;
    const HIGH = 1;
    const LOW = 2;

    private $gamas=[];

    public function __construct()
    {
        $this->gamas = [
            self::EXCLUSIVE => trans('iplaces::places.gama.exclusive'),
            self::HIGH => trans('iplaces::places.gama.high'),
            self::LOW => trans('iplaces::places.gama.low')
        ];
    }

    public function lists()
    {
        return $this->gamas;
    }
    public function get($gamaId)
    {
        if (isset($this->gamas[$gamaId])) {
            return $this->gamas[$gamaId];
        }

        return $this->gamas[self::EXCLUSIVE];
    }

}