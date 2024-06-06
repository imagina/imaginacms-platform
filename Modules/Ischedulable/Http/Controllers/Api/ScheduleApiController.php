<?php

namespace Modules\Ischedulable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;

//Model
use Modules\Ischedulable\Entities\Schedule;
use Modules\Ischedulable\Repositories\ScheduleRepository;

class ScheduleApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Schedule $model, ScheduleRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
