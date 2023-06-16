<?php

namespace Modules\Iblog\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iblog\Entities\Category;
use Modules\Iblog\Repositories\CategoryRepository;

class CategoryApiController extends BaseCrudController
{
    /**
     * @var CategoryRepository
     */
    public $model;

    public $modelRepository;

    public function __construct(Category $model, CategoryRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }
}
