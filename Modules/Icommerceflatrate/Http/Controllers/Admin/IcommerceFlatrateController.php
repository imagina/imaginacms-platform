<?php

namespace Modules\Icommerceflatrate\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommerceflatrate\Entities\IcommerceFlatrate;
use Modules\Icommerceflatrate\Http\Requests\CreateIcommerceFlatrateRequest;
use Modules\Icommerceflatrate\Http\Requests\UpdateIcommerceFlatrateRequest;
use Modules\Icommerceflatrate\Repositories\IcommerceFlatrateRepository;

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
     */
    public function index(): Response
    {
        //$icommerceflatrates = $this->icommerceflatrate->all();

        return view('icommerceflatrate::admin.icommerceflatrates.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icommerceflatrate::admin.icommerceflatrates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIcommerceFlatrateRequest $request): Response
    {
        $this->icommerceflatrate->create($request->all());

        return redirect()->route('admin.icommerceflatrate.icommerceflatrate.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerceflatrate::icommerceflatrates.title.icommerceflatrates')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IcommerceFlatrate $icommerceflatrate): Response
    {
        return view('icommerceflatrate::admin.icommerceflatrates.edit', compact('icommerceflatrate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IcommerceFlatrate $icommerceflatrate, UpdateIcommerceFlatrateRequest $request): Response
    {
        $this->icommerceflatrate->update($icommerceflatrate, $request->all());

        return redirect()->route('admin.icommerceflatrate.icommerceflatrate.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerceflatrate::icommerceflatrates.title.icommerceflatrates')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IcommerceFlatrate $icommerceflatrate): Response
    {
        $this->icommerceflatrate->destroy($icommerceflatrate);

        return redirect()->route('admin.icommerceflatrate.icommerceflatrate.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerceflatrate::icommerceflatrates.title.icommerceflatrates')]));
    }
}
