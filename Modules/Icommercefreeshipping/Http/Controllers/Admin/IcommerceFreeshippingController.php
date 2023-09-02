<?php

namespace Modules\Icommercefreeshipping\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommercefreeshipping\Entities\IcommerceFreeshipping;
use Modules\Icommercefreeshipping\Http\Requests\CreateIcommerceFreeshippingRequest;
use Modules\Icommercefreeshipping\Http\Requests\UpdateIcommerceFreeshippingRequest;
use Modules\Icommercefreeshipping\Repositories\IcommerceFreeshippingRepository;

class IcommerceFreeshippingController extends AdminBaseController
{
    /**
     * @var IcommerceFreeshippingRepository
     */
    private $icommercefreeshipping;

    public function __construct(IcommerceFreeshippingRepository $icommercefreeshipping)
    {
        parent::__construct();

        $this->icommercefreeshipping = $icommercefreeshipping;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$icommercefreeshippings = $this->icommercefreeshipping->all();

        return view('icommercefreeshipping::admin.icommercefreeshippings.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('icommercefreeshipping::admin.icommercefreeshippings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIcommerceFreeshippingRequest $request)
    {
        $this->icommercefreeshipping->create($request->all());

        return redirect()->route('admin.icommercefreeshipping.icommercefreeshipping.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercefreeshipping::icommercefreeshippings.title.icommercefreeshippings')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IcommerceFreeshipping $icommercefreeshipping)
    {
        return view('icommercefreeshipping::admin.icommercefreeshippings.edit', compact('icommercefreeshipping'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IcommerceFreeshipping $icommercefreeshipping, UpdateIcommerceFreeshippingRequest $request)
    {
        $this->icommercefreeshipping->update($icommercefreeshipping, $request->all());

        return redirect()->route('admin.icommercefreeshipping.icommercefreeshipping.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercefreeshipping::icommercefreeshippings.title.icommercefreeshippings')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IcommerceFreeshipping $icommercefreeshipping)
    {
        $this->icommercefreeshipping->destroy($icommercefreeshipping);

        return redirect()->route('admin.icommercefreeshipping.icommercefreeshipping.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercefreeshipping::icommercefreeshippings.title.icommercefreeshippings')]));
    }
}
