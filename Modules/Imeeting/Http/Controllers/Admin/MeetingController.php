<?php

namespace Modules\Imeeting\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Imeeting\Entities\Imeeting;
use Modules\Imeeting\Http\Requests\CreateImeetingRequest;
use Modules\Imeeting\Http\Requests\UpdateImeetingRequest;

class MeetingController extends AdminBaseController
{
    /**
     * @var ImeetingRepository
     */
    private $imeeting;

    private $paymentMethod;

    public function __construct(ImeetingRepository $imeeting)
    {
        parent::__construct();

        $this->imeeting = $imeeting;
        $this->paymentMethod = app('Modules\Icommerce\Repositories\PaymentMethodRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$imeetings = $this->imeeting->all();

        return view('imeeting::admin.imeetings.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('imeeting::admin.imeetings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateImeetingRequest $request): Response
    {
        $this->imeeting->create($request->all());

        return redirect()->route('admin.imeeting.imeeting.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('imeeting::imeetings.title.imeetings')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Imeeting $imeeting): Response
    {
        return view('imeeting::admin.imeetings.edit', compact('imeeting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Imeeting  $imeeting
     */
    public function update($id, UpdateImeetingRequest $request): Response
    {
        //Find payment Method
        $paymentMethod = $this->paymentMethod->find($id);

        //Add status request
        if ($request->status == 'on') {
            $request['status'] = '1';
        } else {
            $request['status'] = '0';
        }

        $this->imeeting->update($paymentMethod, $request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('imeeting::imeetings.single')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imeeting $imeeting): Response
    {
        $this->imeeting->destroy($imeeting);

        return redirect()->route('admin.imeeting.imeeting.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('imeeting::imeetings.title.imeetings')]));
    }
}
