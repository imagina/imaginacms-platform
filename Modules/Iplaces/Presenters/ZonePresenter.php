<?php

namespace Modules\Iplaces\Presenters;

use Laracasts\Presenter\Presenter;


class ZonePresenter extends Presenter
{
    private $zone;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->zone = app('Modules\Iplaces\Repositories\ZoneRepository');

    }

}