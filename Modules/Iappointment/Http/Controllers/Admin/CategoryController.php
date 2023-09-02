<?php

namespace Modules\Iappointment\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iappointment\Entities\Category;
use Modules\Iappointment\Http\Requests\CreateCategoryRequest;
use Modules\Iappointment\Http\Requests\UpdateCategoryRequest;
use Modules\Iappointment\Repositories\CategoryRepository;

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
     */
    public function index()
    {
        //$categories = $this->category->all();

        return view('iappointment::admin.categories.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('iappointment::admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->category->create($request->all());

        return redirect()->route('admin.iappointment.category.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iappointment::categories.title.categories')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('iappointment::admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $this->category->update($category, $request->all());

        return redirect()->route('admin.iappointment.category.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iappointment::categories.title.categories')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->category->destroy($category);

        return redirect()->route('admin.iappointment.category.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iappointment::categories.title.categories')]));
    }
}
