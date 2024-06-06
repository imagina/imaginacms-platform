<?php

namespace Modules\Ischedulable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;

//Model
use Modules\Ischedulable\Entities\Day;
use Modules\Ischedulable\Repositories\DayRepository;

class DayApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Day $model, DayRepository $modelRepository)
  {
    $this->model;
    $this->modelRepository = $modelRepository;
  }
}
