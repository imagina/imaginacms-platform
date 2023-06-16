<?php

namespace Modules\Qreable\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Qreable\Entities\Qr;
use Modules\Qreable\Http\Requests\CreateQrRequest;
use Modules\Qreable\Http\Requests\UpdateQrRequest;
use Modules\Qreable\Repositories\QrRepository;

class QrController extends AdminBaseController
{
    /**
     * @var QrRepository
     */
    private $qr;

    public function __construct(QrRepository $qr)
    {
        parent::__construct();

        $this->qr = $qr;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$locations = $this->qr->all();

        return view('qreable::admin.locations.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('qreable::admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateQrRequest $request)
    {
        $this->qr->create($request->all());

        return redirect()->route('admin.qreable.qr.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('qreable::locations.title.locations')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Qr $qr)
    {
        return view('qreable::admin.locations.edit', compact('qr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Qr $qr, UpdateQrRequest $request)
    {
        $this->qr->update($qr, $request->all());

        return redirect()->route('admin.qreable.qr.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('qreable::locations.title.locations')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Qr $qr)
    {
        $this->qr->destroy($qr);

        return redirect()->route('admin.qreable.qr.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('qreable::locations.title.locations')]));
    }
}
