<?php

namespace Modules\Iad\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iad\Entities\Category;
use Modules\Iad\Repositories\CategoryRepository;

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
