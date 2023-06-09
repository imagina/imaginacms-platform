<?php

namespace Modules\Icommercepricelist\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class PriceListController extends BaseApiController
{
    public $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $params = $this->getParamsRequest($request, ['include' => ['products']]);

        $categories = $this->category->getItemsBy($params);

        return view('icommercepricelist::frontend.index', compact('categories'));
    }
}
