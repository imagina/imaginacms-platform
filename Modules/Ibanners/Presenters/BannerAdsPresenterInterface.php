<?php

namespace Modules\Ibanners\Presenters;

interface BannerAdsPresenterInterface
{
    /**
     * @param  string  $sliderName
     * @return string rendered slider
     */
    public function render($sliderName);
}
