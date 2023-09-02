<?php

namespace Modules\Iad\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iad\Entities\Up;
use Modules\Iad\Http\Requests\CreateUpRequest;
use Modules\Iad\Http\Requests\UpdateUpRequest;
use Modules\Iad\Repositories\UpRepository;

class UpsController extends AdminBaseController
{
    /**
     * @var UpRepository
     */
    private $ups;

    public function __construct(UpRepository $ups)
    {
        parent::__construct();

        $this->ups = $ups;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$ups = $this->ups->all();

        return view('iad::admin.ups.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('iad::admin.ups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUpRequest $request)
    {
        $this->ups->create($request->all());

        return redirect()->route('admin.iad.ups.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::ups.title.ups')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Up $ups)
    {
        return view('iad::admin.ups.edit', compact('ups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Up $ups, UpdateUpRequest $request)
    {
        $this->ups->update($ups, $request->all());

        return redirect()->route('admin.iad.ups.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::ups.title.ups')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Up $ups)
    {
        $this->ups->destroy($ups);

        return redirect()->route('admin.iad.ups.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::ups.title.ups')]));
    }
}
