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
     *
     * @return Response
     */
    public function index(): Response
    {
        //$ups = $this->ups->all();

        return view('iad::admin.ups.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('iad::admin.ups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateUpRequest $request): Response
    {
        $this->ups->create($request->all());

        return redirect()->route('admin.iad.ups.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::ups.title.ups')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Up $ups): Response
    {
        return view('iad::admin.ups.edit', compact('ups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Up $ups, UpdateUpRequest $request): Response
    {
        $this->ups->update($ups, $request->all());

        return redirect()->route('admin.iad.ups.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::ups.title.ups')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Up $ups): Response
    {
        $this->ups->destroy($ups);

        return redirect()->route('admin.iad.ups.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::ups.title.ups')]));
    }
}
