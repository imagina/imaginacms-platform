<?php

namespace Modules\Ibanners\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Ibanners\Presenters\BannerAdsPresenter;

class PositionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BannerAdsPresenter::class;
    }
}
