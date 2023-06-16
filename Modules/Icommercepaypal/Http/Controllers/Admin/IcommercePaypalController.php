<?php

namespace Modules\Icommercepaypal\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommercepaypal\Entities\IcommercePaypal;
use Modules\Icommercepaypal\Http\Requests\CreateIcommercePaypalRequest;
use Modules\Icommercepaypal\Http\Requests\UpdateIcommercePaypalRequest;
use Modules\Icommercepaypal\Repositories\IcommercePaypalRepository;

class IcommercePaypalController extends AdminBaseController
{
    /**
     * @var IcommercePaypalRepository
     */
    private $icommercepaypal;

    private $paymentMethod;

    public function __construct(
        IcommercePaypalRepository $icommercepaypal,
        PaymentMethodRepository $paymentMethod
    ) {
        parent::__construct();
        $this->icommercepaypal = $icommercepaypal;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$icommercepaypals = $this->icommercepaypal->all();

        return view('icommercepaypal::admin.icommercepaypals.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommercepaypal::admin.icommercepaypals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateIcommercePaypalRequest $request)
    {
        $this->icommercepaypal->create($request->all());

        return redirect()->route('admin.icommercepaypal.icommercepaypal.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercepaypal::icommercepaypals.title.icommercepaypals')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(IcommercePaypal $icommercepaypal)
    {
        return view('icommercepaypal::admin.icommercepaypals.edit', compact('icommercepaypal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IcommercePaypal  $icommercepaypal
     * @return Response
     */
    public function update($id, UpdateIcommercePaypalRequest $request)
    {
        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);

        //Add status request
        if ($request->status == 'on') {
            $request['status'] = '1';
        } else {
            $request['status'] = '0';
        }

        $this->icommercepaypal->update($paymentMethod, $request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercepaypal::icommercepaypals.single')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(IcommercePaypal $icommercepaypal)
    {
        $this->icommercepaypal->destroy($icommercepaypal);

        return redirect()->route('admin.icommercepaypal.icommercepaypal.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercepaypal::icommercepaypals.title.icommercepaypals')]));
    }
}
