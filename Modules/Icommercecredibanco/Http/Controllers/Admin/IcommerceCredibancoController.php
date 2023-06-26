<?php

namespace Modules\Icommercecredibanco\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommercecredibanco\Entities\IcommerceCredibanco;
use Modules\Icommercecredibanco\Http\Requests\CreateIcommerceCredibancoRequest;
use Modules\Icommercecredibanco\Http\Requests\UpdateIcommerceCredibancoRequest;
use Modules\Icommercecredibanco\Repositories\IcommerceCredibancoRepository;

class IcommerceCredibancoController extends AdminBaseController
{
    /**
     * @var IcommerceCredibancoRepository
     */
    private $icommercecredibanco;

    public function __construct(IcommerceCredibancoRepository $icommercecredibanco)
    {
        parent::__construct();

        $this->icommercecredibanco = $icommercecredibanco;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$icommercecredibancos = $this->icommercecredibanco->all();

        return view('icommercecredibanco::admin.icommercecredibancos.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icommercecredibanco::admin.icommercecredibancos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIcommerceCredibancoRequest $request): Response
    {
        $this->icommercecredibanco->create($request->all());

        return redirect()->route('admin.icommercecredibanco.icommercecredibanco.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercecredibanco::icommercecredibancos.title.icommercecredibancos')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IcommerceCredibanco $icommercecredibanco): Response
    {
        return view('icommercecredibanco::admin.icommercecredibancos.edit', compact('icommercecredibanco'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IcommerceCredibanco $icommercecredibanco, UpdateIcommerceCredibancoRequest $request): Response
    {
        $this->icommercecredibanco->update($icommercecredibanco, $request->all());

        return redirect()->route('admin.icommercecredibanco.icommercecredibanco.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercecredibanco::icommercecredibancos.title.icommercecredibancos')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IcommerceCredibanco $icommercecredibanco): Response
    {
        $this->icommercecredibanco->destroy($icommercecredibanco);

        return redirect()->route('admin.icommercecredibanco.icommercecredibanco.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercecredibanco::icommercecredibancos.title.icommercecredibancos')]));
    }
}
