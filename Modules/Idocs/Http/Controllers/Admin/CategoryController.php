<?php

namespace Modules\Idocs\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Idocs\Entities\Category;
use Modules\Idocs\Http\Requests\CreateCategoryRequest;
use Modules\Idocs\Http\Requests\UpdateCategoryRequest;
use Modules\Idocs\Repositories\CategoryRepository;

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
        $categories = $this->category->all();

        return view('idocs::admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->all();

        return view('idocs::admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        \DB::beginTransaction();
        try {
            $this->category->create($request->all());
            \DB::commit(); //Commit to Data Base

            return redirect()->route('admin.idocs.category.index')
                ->withSuccess(trans('idocs::common.messages.resource created', ['name' => trans('idocs::categories.title.categories')]));
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());

            return redirect()->back()
                ->withError(trans('idocs::common.messages.resource error', ['name' => trans('idocs:categories.title.categories')]))->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = $this->category->all();

        return view('idocs::admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        \DB::beginTransaction();
        try {
            $this->category->update($category, $request->all());
            \DB::commit(); //Commit to Data Base

            return redirect()->route('admin.idocs.category.index')
                ->withSuccess(trans('idocs::common.messages.resource updated', ['name' => trans('idocs::categories.title.categories')]));
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());

            return redirect()->back()
                ->withError(trans('idocs::common.messages.resource error', ['name' => trans('idocs:categories.title.categories')]))->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        \DB::beginTransaction();
        try {
            $this->category->destroy($category);
            \DB::commit(); //Commit to Data Base

            return redirect()->route('admin.idocs.category.index')
                ->withSuccess(trans('idocs::common.messages.resource deleted', ['name' => trans('idocs::categories.title.categories')]));
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());

            return redirect()->back()
                ->withError(trans('idocs::common.messages.resource error', ['name' => trans('idocs:categories.title.categories')]));
        }
    }
}
