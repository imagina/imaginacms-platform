<?php

namespace Modules\Media\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Media\Entities\Zone;
use Modules\Media\Repositories\ZoneRepository;

class ZoneApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Zone $model, ZoneRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
