<?php

namespace Modules\Ibuilder\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ibuilder\Entities\Block;
use Modules\Ibuilder\Repositories\BlockRepository;

class BlockApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Block $model, BlockRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
