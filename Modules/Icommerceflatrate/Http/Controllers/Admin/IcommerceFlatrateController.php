<?php

namespace Modules\Icommerceflatrate\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerceflatrate\Entities\IcommerceFlatrate;
use Modules\Icommerceflatrate\Http\Requests\CreateIcommerceFlatrateRequest;
use Modules\Icommerceflatrate\Http\Requests\UpdateIcommerceFlatrateRequest;
use Modules\Icommerceflatrate\Repositories\IcommerceFlatrateRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class IcommerceFlatrateController extends AdminBaseController
{
    /**
     * @var IcommerceFlatrateRepository
     */
    private $icommerceflatrate;

    public function __construct(IcommerceFlatrateRepository $icommerceflatrate)
    {
        parent::__construct();

        $this->icommerceflatrate = $icommerceflatrate;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$icommerceflatrates = $this->icommerceflatrate->all();

        return view('icommerceflatrate::admin.icommerceflatrates.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerceflatrate::admin.icommerceflatrates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateIcommerceFlatrateRequest $request
     * @return Response
     */
    public function store(CreateIcommerceFlatrateRequest $request)
    {
        $this->icommerceflatrate->create($request->all());

        return redirect()->route('admin.icommerceflatrate.icommerceflatrate.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerceflatrate::icommerceflatrates.title.icommerceflatrates')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  IcommerceFlatrate $icommerceflatrate
     * @return Response
     */
    public function edit(IcommerceFlatrate $icommerceflatrate)
    {
        return view('icommerceflatrate::admin.icommerceflatrates.edit', compact('icommerceflatrate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommerceFlatrate $icommerceflatrate
     * @param  UpdateIcommerceFlatrateRequest $request
     * @return Response
     */
    public function update(IcommerceFlatrate $icommerceflatrate, UpdateIcommerceFlatrateRequest $request)
    {
        $this->icommerceflatrate->update($icommerceflatrate, $request->all());

        return redirect()->route('admin.icommerceflatrate.icommerceflatrate.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerceflatrate::icommerceflatrates.title.icommerceflatrates')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  IcommerceFlatrate $icommerceflatrate
     * @return Response
     */
    public function destroy(IcommerceFlatrate $icommerceflatrate)
    {
        $this->icommerceflatrate->destroy($icommerceflatrate);

        return redirect()->route('admin.icommerceflatrate.icommerceflatrate.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerceflatrate::icommerceflatrates.title.icommerceflatrates')]));
    }
}
