<?php

namespace Modules\Icommercebraintree\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommercebraintree\Entities\IcommerceBraintree;
use Modules\Icommercebraintree\Http\Requests\CreateIcommerceBraintreeRequest;
use Modules\Icommercebraintree\Http\Requests\UpdateIcommerceBraintreeRequest;
use Modules\Icommercebraintree\Repositories\IcommerceBraintreeRepository;

class IcommerceBraintreeController extends AdminBaseController
{
    /**
     * @var IcommerceBraintreeRepository
     */
    private $icommercebraintree;

    private $paymentMethod;

    public function __construct(IcommerceBraintreeRepository $icommercebraintree)
    {
        parent::__construct();

        $this->icommercebraintree = $icommercebraintree;
        $this->paymentMethod = app('Modules\Icommerce\Repositories\PaymentMethodRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$icommercebraintrees = $this->icommercebraintree->all();

        return view('icommercebraintree::admin.icommercebraintrees.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icommercebraintree::admin.icommercebraintrees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIcommerceBraintreeRequest $request): Response
    {
        $this->icommercebraintree->create($request->all());

        return redirect()->route('admin.icommercebraintree.icommercebraintree.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercebraintree::icommercebraintrees.title.icommercebraintrees')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IcommerceBraintree $icommercebraintree): Response
    {
        return view('icommercebraintree::admin.icommercebraintrees.edit', compact('icommercebraintree'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommerceBraintree  $icommercebraintree
     */
    public function update($id, UpdateIcommerceBraintreeRequest $request): Response
    {
        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);

        //Add status request
        if ($request->status == 'on') {
            $request['status'] = '1';
        } else {
            $request['status'] = '0';
        }

        $this->icommercebraintree->update($paymentMethod, $request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercebraintree::icommercebraintrees.single')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IcommerceBraintree $icommercebraintree): Response
    {
        $this->icommercebraintree->destroy($icommercebraintree);

        return redirect()->route('admin.icommercebraintree.icommercebraintree.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercebraintree::icommercebraintrees.title.icommercebraintrees')]));
    }
}
