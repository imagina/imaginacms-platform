<?php

namespace Modules\Icommerceepayco\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerceepayco\Entities\IcommerceEpayco;
use Modules\Icommerceepayco\Http\Requests\CreateIcommerceEpaycoRequest;
use Modules\Icommerceepayco\Http\Requests\UpdateIcommerceEpaycoRequest;
use Modules\Icommerceepayco\Repositories\IcommerceEpaycoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommerce\Repositories\PaymentMethodRepository;

class IcommerceEpaycoController extends AdminBaseController
{
    /**
     * @var IcommerceEpaycoRepository
     */
    private $icommerceepayco;
    private $paymentMethod;

    public function __construct(
        IcommerceEpaycoRepository $icommerceepayco,
        PaymentMethodRepository $paymentMethod
    ){
        parent::__construct();

        $this->icommerceepayco = $icommerceepayco;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$icommerceepaycos = $this->icommerceepayco->all();

        return view('icommerceepayco::admin.icommerceepaycos.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerceepayco::admin.icommerceepaycos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateIcommerceEpaycoRequest $request
     * @return Response
     */
    public function store(CreateIcommerceEpaycoRequest $request)
    {
        $this->icommerceepayco->create($request->all());

        return redirect()->route('admin.icommerceepayco.icommerceepayco.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerceepayco::icommerceepaycos.title.icommerceepaycos')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  IcommerceEpayco $icommerceepayco
     * @return Response
     */
    public function edit(IcommerceEpayco $icommerceepayco)
    {
        return view('icommerceepayco::admin.icommerceepaycos.edit', compact('icommerceepayco'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommerceEpayco $icommerceepayco
     * @param  UpdateIcommerceEpaycoRequest $request
     * @return Response
     */
    public function update($id, UpdateIcommerceEpaycoRequest $request)
    {

        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);

        //Add status request
        if($request->status=='on')
            $request['status'] = "1";
        else
            $request['status'] = "0";

        $this->icommerceepayco->update($paymentMethod,$request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerceepayco::icommerceepaycos.single')]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  IcommerceEpayco $icommerceepayco
     * @return Response
     */
    public function destroy(IcommerceEpayco $icommerceepayco)
    {
        $this->icommerceepayco->destroy($icommerceepayco);

        return redirect()->route('admin.icommerceepayco.icommerceepayco.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerceepayco::icommerceepaycos.title.icommerceepaycos')]));
    }
}
