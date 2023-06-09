<?php

namespace Modules\Ipoint\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Ipoint\Entities\Point;
use Modules\Ipoint\Repositories\PointRepository;

class PointApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Point $model, PointRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
