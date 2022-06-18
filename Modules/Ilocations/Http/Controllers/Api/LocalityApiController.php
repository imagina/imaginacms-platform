<?php

namespace Modules\Ilocations\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ilocations\Entities\Locality;
use Modules\Ilocations\Repositories\LocalityRepository;

class LocalityApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Locality $model, LocalityRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
