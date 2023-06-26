<?php

namespace Modules\Icommercewompi\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommercewompi\Entities\IcommerceWompi;
use Modules\Icommercewompi\Http\Requests\CreateIcommerceWompiRequest;
use Modules\Icommercewompi\Http\Requests\UpdateIcommerceWompiRequest;
use Modules\Icommercewompi\Repositories\IcommerceWompiRepository;

class IcommerceWompiController extends AdminBaseController
{
    /**
     * @var IcommerceWompiRepository
     */
    private $icommercewompi;

    private $paymentMethod;

    public function __construct(
        IcommerceWompiRepository $icommercewompi,
        PaymentMethodRepository $paymentMethod
    ) {
        parent::__construct();

        $this->icommercewompi = $icommercewompi;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$icommercewompis = $this->icommercewompi->all();

        return view('icommercewompi::admin.icommercewompis.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icommercewompi::admin.icommercewompis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIcommerceWompiRequest $request): Response
    {
        $this->icommercewompi->create($request->all());

        return redirect()->route('admin.icommercewompi.icommercewompi.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercewompi::icommercewompis.title.icommercewompis')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IcommerceWompi $icommercewompi): Response
    {
        return view('icommercewompi::admin.icommercewompis.edit', compact('icommercewompi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommerceWompi  $icommercewompi
     */
    public function update($id, UpdateIcommerceWompiRequest $request): Response
    {
        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);

        //Add status request
        if ($request->status == 'on') {
            $request['status'] = '1';
        } else {
            $request['status'] = '0';
        }

        $this->icommercewompi->update($paymentMethod, $request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercewompi::icommercewompis.single')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IcommerceWompi $icommercewompi): Response
    {
        $this->icommercewompi->destroy($icommercewompi);

        return redirect()->route('admin.icommercewompi.icommercewompi.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercewompi::icommercewompis.title.icommercewompis')]));
    }
}
