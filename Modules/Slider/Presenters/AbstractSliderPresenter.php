<?php

namespace Modules\Slider\Presenters;

use Modules\Slider\Repositories\SliderRepository;

abstract class AbstractSliderPresenter implements SliderPresenterInterface
{
    /**
     * @var SliderRepository
     */
    protected $sliderRepository;

    /**
     * SliderPresenter constructor.
     */
    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }
}
