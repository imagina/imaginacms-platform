<?php

namespace Modules\Iplaces\Entities;


class Weather
{
    const CLOUDY = 0;
    const WARM = 1;
    const TEMPERED = 2;

    private $weathers=[];

    public function __construct()
    {
        $this->weathers = [
            self::CLOUDY => trans('iplaces::places.weather.cloudy'),
            self::WARM => trans('iplaces::places.weather.warm'),
            self::TEMPERED => trans('iplaces::places.weather.tempered')
        ];
    }

    public function lists()
    {
        return $this->weathers;
    }
    public function get($weatherId)
    {
        if (isset($this->weathers[$weatherId])) {
            return $this->weathers[$weatherId];
        }

        return $this->weathers[self::WARM];
    }

}