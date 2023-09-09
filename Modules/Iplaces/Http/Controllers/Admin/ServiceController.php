<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iplaces\Entities\Service;
use Modules\Iplaces\Entities\Servtype;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Http\Requests\CreateServiceRequest;
use Modules\Iplaces\Http\Requests\UpdateServiceRequest;
use Modules\Iplaces\Repositories\ServiceRepository;

class ServiceController extends AdminBaseController
{
    /**
     * @var ServiceRepository
     */
    private $service;

    public $status;

    public $servtype;

    public function __construct(ServiceRepository $service, Status $status, Servtype $servtype)
    {
        parent::__construct();

        $this->service = $service;
        $this->status = $status;
        $this->servtype = $servtype;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = $this->service->all();

        return view('iplaces::admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = $this->status->lists();
        $servtypes = $this->servtype->lists();
        $services = $this->service->paginate(20);

        return view('iplaces::admin.services.create', compact('services', 'statuses', 'servtypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateServiceRequest $request)
    {
        try {
            $this->service->create($request->all());

            return redirect()->route('admin.iplaces.service.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::services.title.services')]));
        } catch(\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::services.title.services')]))->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {//dd($service);
        //$services = $this->service->paginate(20);
        $statuses = $this->status->lists();
        $servtypes = $this->servtype->lists();

        return view('iplaces::admin.services.edit', compact('service', 'statuses', 'servtypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Service $service, UpdateServiceRequest $request)
    {
        try {
            $this->service->update($service, $request->all());

            return redirect()->route('admin.iplaces.service.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::services.title.services')]));
        } catch(\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::services.title.services')]))->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        try {
            $this->service->destroy($service);

            return redirect()->route('admin.iplaces.service.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::services.title.services')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('services::services.title.services')]));
        }
    }
}
