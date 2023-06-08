<?php

namespace Modules\Ibooking\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;

//Model Repository
use Modules\Ibooking\Repositories\ReservationItemRepository;
use Modules\Ibooking\Entities\ReservationItem;

class ReservationItemApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ReservationItem $model, ReservationItemRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
