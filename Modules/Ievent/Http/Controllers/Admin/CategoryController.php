<?php

namespace Modules\Ievent\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ievent\Entities\Category;
use Modules\Ievent\Http\Requests\CreateCategoryRequest;
use Modules\Ievent\Http\Requests\UpdateCategoryRequest;
use Modules\Ievent\Repositories\CategoryRepository;

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
    public function index()
    {
        //$categories = $this->category->all();

        return view('ievent::admin.categories.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ievent::admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->category->create($request->all());

        return redirect()->route('admin.ievent.category.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ievent::categories.title.categories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Category $category)
    {
        return view('ievent::admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $this->category->update($category, $request->all());

        return redirect()->route('admin.ievent.category.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ievent::categories.title.categories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Category $category)
    {
        $this->category->destroy($category);

        return redirect()->route('admin.ievent.category.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ievent::categories.title.categories')]));
    }
}
