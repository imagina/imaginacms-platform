<?php

namespace Modules\Igamification\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Igamification\Entities\Activity;
use Modules\Igamification\Repositories\ActivityRepository;

class ActivityApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Activity $model, ActivityRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
