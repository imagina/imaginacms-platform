<?php

namespace Modules\Icommercepayu\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommercepayu\Entities\IcommercePayu;
use Modules\Icommercepayu\Http\Requests\CreateIcommercePayuRequest;
use Modules\Icommercepayu\Http\Requests\UpdateIcommercePayuRequest;
use Modules\Icommercepayu\Repositories\IcommercePayuRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommerce\Repositories\PaymentMethodRepository;

class IcommercePayuController extends AdminBaseController
{
    /**
     * @var IcommercePayuRepository
     */
    private $icommercepayu;
    private $paymentMethod;

    public function __construct(
        IcommercePayuRepository $icommercepayu,
        PaymentMethodRepository $paymentMethod
    ){
        parent::__construct();

        $this->icommercepayu = $icommercepayu;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$icommercepayus = $this->icommercepayu->all();

        return view('icommercepayu::admin.icommercepayus.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommercepayu::admin.icommercepayus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateIcommercePayuRequest $request
     * @return Response
     */
    public function store(CreateIcommercePayuRequest $request)
    {
        $this->icommercepayu->create($request->all());

        return redirect()->route('admin.icommercepayu.icommercepayu.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercepayu::icommercepayus.title.icommercepayus')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  IcommercePayu $icommercepayu
     * @return Response
     */
    public function edit(IcommercePayu $icommercepayu)
    {
        return view('icommercepayu::admin.icommercepayus.edit', compact('icommercepayu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommercePayu $icommercepayu
     * @param  UpdateIcommercePayuRequest $request
     * @return Response
     */
    public function update($id, UpdateIcommercePayuRequest $request)
    {

        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);

        //Add status request
        if($request->status=='on')
            $request['status'] = "1";
        else
            $request['status'] = "0";

        $this->icommercepayu->update($paymentMethod,$request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercepayu::icommercepayus.single')]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  IcommercePayu $icommercepayu
     * @return Response
     */
    public function destroy(IcommercePayu $icommercepayu)
    {
        $this->icommercepayu->destroy($icommercepayu);

        return redirect()->route('admin.icommercepayu.icommercepayu.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercepayu::icommercepayus.title.icommercepayus')]));
    }
}
