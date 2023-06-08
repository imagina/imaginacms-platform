<?php

namespace Modules\Iplaces\Presenters;

use Laracasts\Presenter\Presenter;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Entities\Weather;

class PlacePresenter extends Presenter
{
    /**
     * @var \Modules\Iplaces\Entities\Status
     */
    protected $status;
    protected $weather;
    /**
     * @var \Modules\Iplaces\Repositories\PlaceRepository
     */
    private $place;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->place = app('Modules\Iplaces\Repositories\PlaceRepository');
        $this->status = app('Modules\Iplaces\Entities\Status');
        $this->weather=app('Modules\Iplaces\Entities\Weather');
    }

    /**
     * Get the post status
     * @return string
     */
    public function status()
    {
        return $this->status->get($this->entity->status);
    }
    public function weather()
    {
        return $this->weather->get($this->entity->weather);
    }

    /**
     * Getting the label class for the appropriate status
     * @return string
     */
    public function statusLabelClass()
    {
        switch ($this->entity->status) {
            case Status::INACTIVE:
                return 'bg-red';
                break;

            case Status::ACTIVE:
                return 'bg-green';
                break;

            default:
                return 'bg-red';
                break;
        }
    }
    public function weatherLabelClass()
    {
        switch ($this->entity->weather) {
            case Weather::CLOUDY:
                return 'bg-red';
                break;

            case Weather::WARM:
                return 'bg-green';
                break;

            default:
                return 'bg-red';
                break;
        }
    }
}
