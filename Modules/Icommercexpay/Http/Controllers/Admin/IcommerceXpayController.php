<?php

namespace Modules\Icommercexpay\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommercexpay\Entities\IcommerceXpay;
use Modules\Icommercexpay\Http\Requests\CreateIcommerceXpayRequest;
use Modules\Icommercexpay\Http\Requests\UpdateIcommerceXpayRequest;
use Modules\Icommercexpay\Repositories\IcommerceXpayRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
     *
     * @return Response
     */
    public function index()
    {
        //$icommercexpays = $this->icommercexpay->all();

        return view('icommercexpay::admin.icommercexpays.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommercexpay::admin.icommercexpays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateIcommerceXpayRequest $request
     * @return Response
     */
    public function store(CreateIcommerceXpayRequest $request)
    {
        $this->icommercexpay->create($request->all());

        return redirect()->route('admin.icommercexpay.icommercexpay.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercexpay::icommercexpays.title.icommercexpays')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  IcommerceXpay $icommercexpay
     * @return Response
     */
    public function edit(IcommerceXpay $icommercexpay)
    {
        return view('icommercexpay::admin.icommercexpays.edit', compact('icommercexpay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommerceXpay $icommercexpay
     * @param  UpdateIcommerceXpayRequest $request
     * @return Response
     */
    public function update($id, UpdateIcommerceXpayRequest $request)
    {

        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);
        
        //Add status request
        if($request->status=='on')
            $request['status'] = "1";
        else
            $request['status'] = "0";

        $this->icommercexpay->update($paymentMethod,$request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercexpay::icommercexpays.single')]));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  IcommerceXpay $icommercexpay
     * @return Response
     */
    public function destroy(IcommerceXpay $icommercexpay)
    {
        $this->icommercexpay->destroy($icommercexpay);

        return redirect()->route('admin.icommercexpay.icommercexpay.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercexpay::icommercexpays.title.icommercexpays')]));
    }

    

}
