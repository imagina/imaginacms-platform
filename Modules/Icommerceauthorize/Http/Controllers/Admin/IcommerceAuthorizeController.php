<?php

namespace Modules\Icommerceauthorize\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerceauthorize\Entities\IcommerceAuthorize;
use Modules\Icommerceauthorize\Http\Requests\CreateIcommerceAuthorizeRequest;
use Modules\Icommerceauthorize\Http\Requests\UpdateIcommerceAuthorizeRequest;
use Modules\Icommerceauthorize\Repositories\IcommerceAuthorizeRepository;

class IcommerceAuthorizeController extends AdminBaseController
{
    /**
     * @var IcommerceAuthorizeRepository
     */
    private $icommerceauthorize;

    private $paymentMethod;

    public function __construct(
        IcommerceAuthorizeRepository $icommerceauthorize,
        PaymentMethodRepository $paymentMethod
    ) {
        parent::__construct();
        $this->icommerceauthorize = $icommerceauthorize;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$icommerceauthorizes = $this->icommerceauthorize->all();

        return view('icommerceauthorize::admin.icommerceauthorizes.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icommerceauthorize::admin.icommerceauthorizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIcommerceAuthorizeRequest $request): Response
    {
        $this->icommerceauthorize->create($request->all());

        return redirect()->route('admin.icommerceauthorize.icommerceauthorize.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerceauthorize::icommerceauthorizes.title.icommerceauthorizes')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IcommerceAuthorize $icommerceauthorize): Response
    {
        return view('icommerceauthorize::admin.icommerceauthorizes.edit', compact('icommerceauthorize'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommerceAuthorize  $icommerceauthorize
     */
    public function update($id, UpdateIcommerceAuthorizeRequest $request): Response
    {
        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);

        //Add status request
        if ($request->status == 'on') {
            $request['status'] = '1';
        } else {
            $request['status'] = '0';
        }

        $this->icommerceauthorize->update($paymentMethod, $request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerceauthorize::icommerceauthorizes.single')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IcommerceAuthorize $icommerceauthorize): Response
    {
        $this->icommerceauthorize->destroy($icommerceauthorize);

        return redirect()->route('admin.icommerceauthorize.icommerceauthorize.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerceauthorize::icommerceauthorizes.title.icommerceauthorizes')]));
    }
}
