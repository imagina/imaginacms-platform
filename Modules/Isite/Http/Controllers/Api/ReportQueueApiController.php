<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Isite\Entities\ReportQueue;
use Modules\Isite\Repositories\ReportQueueRepository;

class ReportQueueApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ReportQueue $model, ReportQueueRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
