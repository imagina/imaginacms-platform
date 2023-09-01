<?php

namespace Modules\Ibooking\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model Repository
use Modules\Ibooking\Entities\Service;
use Modules\Ibooking\Repositories\ServiceRepository;

class ServiceApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Service $model, ServiceRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
