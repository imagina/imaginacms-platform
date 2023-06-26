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
     */
    public function index(): Response
    {
        //$locations = $this->qr->all();

        return view('qreable::admin.locations.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('qreable::admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateQrRequest $request): Response
    {
        $this->qr->create($request->all());

        return redirect()->route('admin.qreable.qr.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('qreable::locations.title.locations')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Qr $qr): Response
    {
        return view('qreable::admin.locations.edit', compact('qr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Qr $qr, UpdateQrRequest $request): Response
    {
        $this->qr->update($qr, $request->all());

        return redirect()->route('admin.qreable.qr.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('qreable::locations.title.locations')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Qr $qr): Response
    {
        $this->qr->destroy($qr);

        return redirect()->route('admin.qreable.qr.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('qreable::locations.title.locations')]));
    }
}
