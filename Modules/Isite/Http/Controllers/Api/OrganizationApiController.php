<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Isite\Entities\Organization;
use Modules\Isite\Repositories\OrganizationRepository;

class OrganizationApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Organization $model, OrganizationRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
