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
     *
     * @return Response
     */
    public function index(): Response
    {
        //$icommercefreeshippings = $this->icommercefreeshipping->all();

        return view('icommercefreeshipping::admin.icommercefreeshippings.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('icommercefreeshipping::admin.icommercefreeshippings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateIcommerceFreeshippingRequest $request): Response
    {
        $this->icommercefreeshipping->create($request->all());

        return redirect()->route('admin.icommercefreeshipping.icommercefreeshipping.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercefreeshipping::icommercefreeshippings.title.icommercefreeshippings')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(IcommerceFreeshipping $icommercefreeshipping): Response
    {
        return view('icommercefreeshipping::admin.icommercefreeshippings.edit', compact('icommercefreeshipping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(IcommerceFreeshipping $icommercefreeshipping, UpdateIcommerceFreeshippingRequest $request): Response
    {
        $this->icommercefreeshipping->update($icommercefreeshipping, $request->all());

        return redirect()->route('admin.icommercefreeshipping.icommercefreeshipping.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercefreeshipping::icommercefreeshippings.title.icommercefreeshippings')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(IcommerceFreeshipping $icommercefreeshipping): Response
    {
        $this->icommercefreeshipping->destroy($icommercefreeshipping);

        return redirect()->route('admin.icommercefreeshipping.icommercefreeshipping.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercefreeshipping::icommercefreeshippings.title.icommercefreeshippings')]));
    }
}
