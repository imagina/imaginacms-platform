<?php

namespace Modules\Iad\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iad\Entities\Category;
use Modules\Iad\Http\Requests\CreateCategoryRequest;
use Modules\Iad\Http\Requests\UpdateCategoryRequest;
use Modules\Iad\Repositories\CategoryRepository;

class CategoryController extends AdminBaseController
{
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(CategoryRepository $category)
    {
        parent::__construct();

        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //$categories = $this->category->all();

        return view('iad::admin.categories.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('iad::admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request): Response
    {
        $this->category->create($request->all());

        return redirect()->route('admin.iad.category.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::categories.title.categories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Category $category): Response
    {
        return view('iad::admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Category $category, UpdateCategoryRequest $request): Response
    {
        $this->category->update($category, $request->all());

        return redirect()->route('admin.iad.category.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::categories.title.categories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Category $category): Response
    {
        $this->category->destroy($category);

        return redirect()->route('admin.iad.category.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::categories.title.categories')]));
    }
}
