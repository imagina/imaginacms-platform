<?php

namespace Modules\Iplaces\Presenters;

use Laracasts\Presenter\Presenter;


class SchedulePresenter extends Presenter
{
    private $schedule;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->schedule = app('Modules\Iplaces\Repositories\ScheduleRepository');

    }

}