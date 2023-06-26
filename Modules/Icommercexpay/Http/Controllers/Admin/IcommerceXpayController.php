<?php

namespace Modules\Icommercexpay\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommercexpay\Entities\IcommerceXpay;
use Modules\Icommercexpay\Http\Requests\CreateIcommerceXpayRequest;
use Modules\Icommercexpay\Http\Requests\UpdateIcommerceXpayRequest;
use Modules\Icommercexpay\Repositories\IcommerceXpayRepository;

class IcommerceXpayController extends AdminBaseController
{
    /**
     * @var IcommerceXpayRepository
     */
    private $icommercexpay;

    private $paymentMethod;

    public function __construct(IcommerceXpayRepository $icommercexpay)
    {
        parent::__construct();

        $this->icommercexpay = $icommercexpay;
        $this->paymentMethod = app('Modules\Icommerce\Repositories\PaymentMethodRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$icommercexpays = $this->icommercexpay->all();

        return view('icommercexpay::admin.icommercexpays.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icommercexpay::admin.icommercexpays.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIcommerceXpayRequest $request): Response
    {
        $this->icommercexpay->create($request->all());

        return redirect()->route('admin.icommercexpay.icommercexpay.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercexpay::icommercexpays.title.icommercexpays')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IcommerceXpay $icommercexpay): Response
    {
        return view('icommercexpay::admin.icommercexpays.edit', compact('icommercexpay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommerceXpay  $icommercexpay
     */
    public function update($id, UpdateIcommerceXpayRequest $request): Response
    {
        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);

        //Add status request
        if ($request->status == 'on') {
            $request['status'] = '1';
        } else {
            $request['status'] = '0';
        }

        $this->icommercexpay->update($paymentMethod, $request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercexpay::icommercexpays.single')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IcommerceXpay $icommercexpay): Response
    {
        $this->icommercexpay->destroy($icommercexpay);

        return redirect()->route('admin.icommercexpay.icommercexpay.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercexpay::icommercexpays.title.icommercexpays')]));
    }
}
