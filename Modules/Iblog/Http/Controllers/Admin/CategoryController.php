<?php

namespace Modules\Iblog\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iblog\Entities\Category;
use Modules\Iblog\Http\Requests\CreateCategoryRequest;
use Modules\Iblog\Repositories\CategoryRepository;


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
        $categories = $this->category->all();

        return view('iblog::admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $categories = $this->category->all();
        return view('iblog::admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest $request
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        \DB::beginTransaction();
        try {
            $this->category->create($request->all());
            \DB::commit();//Commit to Data Base
            return redirect()->route('admin.iblog.category.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iblog::category.title.categories')]));

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iblog::category.title.categories')]))->withInput($request->all());

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function edit(Category $category)
    {

        $categories = $this->category->all();
        return view('iblog::admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Category $Category
     * @param CreateCategoryRequest $request
     * @return Response
     */
    public function update(Category $Category, CreateCategoryRequest $request)
    {
        try {
            $this->category->update($Category, $request->all());

            return redirect()->route('admin.iblog.category.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iblog::category.title.categories')]));
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iblog::category.title.categories')]))->withInput($request->all());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $Category
     * @return Response
     */
    public function destroy(Category $Category)
    {
        try {
            $this->category->destroy($Category);

            return redirect()->route('admin.iblog.category.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iblog::category.title.categories')]));
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iblog::category.title.categories')]));

        }
    }


}
