<?php

namespace Modules\Ibooking\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model Repository
use Modules\Ibooking\Entities\Category;
use Modules\Ibooking\Repositories\CategoryRepository;

class CategoryApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Category $model, CategoryRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
