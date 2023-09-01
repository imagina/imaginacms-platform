<?php

namespace Modules\Iad\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iad\Entities\AdUp;
use Modules\Iad\Http\Requests\CreateAdUpRequest;
use Modules\Iad\Http\Requests\UpdateAdUpRequest;
use Modules\Iad\Repositories\AdUpRepository;

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
     */
    public function index(): Response
    {
        //$adups = $this->adup->all();

        return view('iad::admin.adups.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('iad::admin.adups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAdUpRequest $request): Response
    {
        $this->adup->create($request->all());

        return redirect()->route('admin.iad.adup.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::adups.title.adups')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdUp $adup): Response
    {
        return view('iad::admin.adups.edit', compact('adup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdUp $adup, UpdateAdUpRequest $request): Response
    {
        $this->adup->update($adup, $request->all());

        return redirect()->route('admin.iad.adup.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::adups.title.adups')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdUp $adup): Response
    {
        $this->adup->destroy($adup);

        return redirect()->route('admin.iad.adup.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::adups.title.adups')]));
    }
}
