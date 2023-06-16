<?php

namespace Modules\Iad\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iad\Repositories\ScheduleRepository;
use Modules\Iplaces\Entities\Schedule;

class ScheduleController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Schedule $model, ScheduleRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
