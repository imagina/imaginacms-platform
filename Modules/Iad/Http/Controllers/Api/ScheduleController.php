<?php


namespace Modules\Iad\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iplaces\Entities\Schedule;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iad\Http\Requests\CreateScheduleRequest;
use Modules\Iad\Http\Requests\UpdateScheduleRequest;
use Modules\Iad\Repositories\ScheduleRepository;
use Modules\Iad\Transformers\ScheduleTransformer;
use Route;

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
