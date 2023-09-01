<?php

namespace Modules\Imeeting\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model Repository
use Modules\Imeeting\Entities\Provider;
use Modules\Imeeting\Repositories\ProviderRepository;

class ProviderApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Provider $model, ProviderRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
