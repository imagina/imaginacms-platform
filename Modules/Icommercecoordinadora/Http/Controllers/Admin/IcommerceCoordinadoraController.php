<?php

namespace Modules\Icommercecoordinadora\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommercecoordinadora\Entities\IcommerceCoordinadora;
use Modules\Icommercecoordinadora\Http\Requests\CreateIcommerceCoordinadoraRequest;
use Modules\Icommercecoordinadora\Http\Requests\UpdateIcommerceCoordinadoraRequest;
use Modules\Icommercecoordinadora\Repositories\IcommerceCoordinadoraRepository;

class IcommerceCoordinadoraController extends AdminBaseController
{
    /**
     * @var IcommerceCoordinadoraRepository
     */
    private $icommercecoordinadora;

    public function __construct(IcommerceCoordinadoraRepository $icommercecoordinadora)
    {
        parent::__construct();

        $this->icommercecoordinadora = $icommercecoordinadora;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$icommercecoordinadoras = $this->icommercecoordinadora->all();

        return view('icommercecoordinadora::admin.icommercecoordinadoras.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icommercecoordinadora::admin.icommercecoordinadoras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIcommerceCoordinadoraRequest $request): Response
    {
        $this->icommercecoordinadora->create($request->all());

        return redirect()->route('admin.icommercecoordinadora.icommercecoordinadora.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercecoordinadora::icommercecoordinadoras.title.icommercecoordinadoras')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IcommerceCoordinadora $icommercecoordinadora): Response
    {
        return view('icommercecoordinadora::admin.icommercecoordinadoras.edit', compact('icommercecoordinadora'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IcommerceCoordinadora $icommercecoordinadora, UpdateIcommerceCoordinadoraRequest $request): Response
    {
        $this->icommercecoordinadora->update($icommercecoordinadora, $request->all());

        return redirect()->route('admin.icommercecoordinadora.icommercecoordinadora.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercecoordinadora::icommercecoordinadoras.title.icommercecoordinadoras')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IcommerceCoordinadora $icommercecoordinadora): Response
    {
        $this->icommercecoordinadora->destroy($icommercecoordinadora);

        return redirect()->route('admin.icommercecoordinadora.icommercecoordinadora.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercecoordinadora::icommercecoordinadoras.title.icommercecoordinadoras')]));
    }
}
