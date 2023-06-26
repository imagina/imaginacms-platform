<?php

namespace Modules\Icommercecheckmo\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommercecheckmo\Entities\IcommerceCheckmo;
use Modules\Icommercecheckmo\Http\Requests\CreateIcommerceCheckmoRequest;
use Modules\Icommercecheckmo\Http\Requests\UpdateIcommerceCheckmoRequest;
use Modules\Icommercecheckmo\Repositories\IcommerceCheckmoRepository;

class IcommerceCheckmoController extends AdminBaseController
{
    /**
     * @var IcommerceCheckmoRepository
     */
    private $icommercecheckmo;

    private $paymentMethod;

    public function __construct(IcommerceCheckmoRepository $icommercecheckmo)
    {
        parent::__construct();

        $this->icommercecheckmo = $icommercecheckmo;
        $this->paymentMethod = app('Modules\Icommerce\Repositories\PaymentMethodRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$icommercecheckmos = $this->icommercecheckmo->all();

        return view('icommercecheckmo::admin.icommercecheckmos.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icommercecheckmo::admin.icommercecheckmos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIcommerceCheckmoRequest $request): Response
    {
        $this->icommercecheckmo->create($request->all());

        return redirect()->route('admin.icommercecheckmo.icommercecheckmo.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercecheckmo::icommercecheckmos.title.icommercecheckmos')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IcommerceCheckmo $icommercecheckmo): Response
    {
        return view('icommercecheckmo::admin.icommercecheckmos.edit', compact('icommercecheckmo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommerceCheckmo  $icommercecheckmo
     */
    public function update($id, UpdateIcommerceCheckmoRequest $request): Response
    {
        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);

        //Add status request
        if ($request->status == 'on') {
            $request['status'] = '1';
        } else {
            $request['status'] = '0';
        }

        $this->icommercecheckmo->update($paymentMethod, $request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercecheckmo::icommercecheckmos.single')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IcommerceCheckmo $icommercecheckmo): Response
    {
        $this->icommercecheckmo->destroy($icommercecheckmo);

        return redirect()->route('admin.icommercecheckmo.icommercecheckmo.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercecheckmo::icommercecheckmos.title.icommercecheckmos')]));
    }
}
