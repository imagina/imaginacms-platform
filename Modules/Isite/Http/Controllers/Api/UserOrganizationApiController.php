<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Isite\Entities\UserOrganization;
use Modules\Isite\Repositories\UserOrganizationRepository;

class UserOrganizationApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(UserOrganization $model, UserOrganizationRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
