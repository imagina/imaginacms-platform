<?php

namespace Modules\Ibinnacle\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ibinnacle\Entities\Binnacle;
use Modules\Ibinnacle\Repositories\BinnacleRepository;

class BinnacleApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Binnacle $model, BinnacleRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
