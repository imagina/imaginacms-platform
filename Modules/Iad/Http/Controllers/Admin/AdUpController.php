<?php

namespace Modules\Iad\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iad\Entities\AdUp;
use Modules\Iad\Http\Requests\CreateAdUpRequest;
use Modules\Iad\Http\Requests\UpdateAdUpRequest;
use Modules\Iad\Repositories\AdUpRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AdUpController extends AdminBaseController
{
    /**
     * @var AdUpRepository
     */
    private $adup;

    public function __construct(AdUpRepository $adup)
    {
        parent::__construct();

        $this->adup = $adup;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$adups = $this->adup->all();

        return view('iad::admin.adups.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iad::admin.adups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAdUpRequest $request
     * @return Response
     */
    public function store(CreateAdUpRequest $request)
    {
        $this->adup->create($request->all());

        return redirect()->route('admin.iad.adup.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::adups.title.adups')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AdUp $adup
     * @return Response
     */
    public function edit(AdUp $adup)
    {
        return view('iad::admin.adups.edit', compact('adup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdUp $adup
     * @param  UpdateAdUpRequest $request
     * @return Response
     */
    public function update(AdUp $adup, UpdateAdUpRequest $request)
    {
        $this->adup->update($adup, $request->all());

        return redirect()->route('admin.iad.adup.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::adups.title.adups')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AdUp $adup
     * @return Response
     */
    public function destroy(AdUp $adup)
    {
        $this->adup->destroy($adup);

        return redirect()->route('admin.iad.adup.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::adups.title.adups')]));
    }
}
