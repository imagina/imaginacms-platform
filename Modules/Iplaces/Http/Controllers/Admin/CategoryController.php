<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iplaces\Entities\Category;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Http\Requests\CreateCategoryRequest;
use Modules\Iplaces\Http\Requests\UpdateCategoryRequest;
use Modules\Iplaces\Repositories\CategoryRepository;

class CategoryController extends AdminBaseController
{
    /**
     * @var CategoryRepository
     */
    private $category;

    public $status;
    // public $file;

    public function __construct(CategoryRepository $category, Status $status)
    {
        parent::__construct();

        $this->category = $category;
        $this->status = $status;
        // $this->file = $file;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $categories = $this->category->all();

        return view('iplaces::admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $statuses = $this->status->lists();
        $categories = $this->category->all();

        return view('iplaces::admin.categories.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request): Response
    {
        // dd($request);
        try {
            $this->category->create($request->all());

            return redirect()->route('admin.iplaces.category.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::categories.title.categories')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::categories.title.categories')]))->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): Response
    {
        //dd($category->mainimage);
        $statuses = $this->status->lists();
        $categories = $this->category->all();
        //  $thumbnail = $this->file->findFileByZoneForEntity('thumbnail', $category);
        return view('iplaces::admin.categories.edit', compact('category', 'statuses', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Category $category, CreateCategoryRequest $request): Response
    {
        try {
            if (isset($request['options'])) {
                $options = (array) $request['options'];
            } else {
                $options = [];
            }

            isset($request->mainimage) ? $options['mainimage'] = saveImage($request['mainimage'], 'assets/iplaces/category/'.$category->id.'.jpg') : false;
            $request['options'] = json_encode($options);
            $this->category->update($category, $request->all());

            return redirect()->route('admin.iplaces.category.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::categories.title.categories')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::categories.title.categories')]))->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): Response
    {
        try {
            $this->category->destroy($category);

            return redirect()->route('admin.iplaces.category.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::categories.title.categories')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::categories.title.categories')]));
        }
    }
}
