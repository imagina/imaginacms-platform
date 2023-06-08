<?php

namespace Modules\Ibooking\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;

//Model
use Modules\Ibooking\Entities\Resource;
use Modules\Ibooking\Repositories\ResourceRepository;

class ResourceApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Resource $model, ResourceRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
