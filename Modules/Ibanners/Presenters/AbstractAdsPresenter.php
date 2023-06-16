<?php

namespace Modules\Ibanners\Presenters;

use Modules\Ibanners\Repositories\PositionRepository;

abstract class AbstractAdsPresenter implements BannerAdsPresenterInterface
{
    /**
     * @var PositionRepository
     */
    protected $positionRepository;

    /**
     * SliderPresenter constructor.
     */
    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }
}
