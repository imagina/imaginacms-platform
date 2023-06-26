<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iplaces\Entities\Zone;
use Modules\Iplaces\Http\Requests\CreateZoneRequest;
use Modules\Iplaces\Http\Requests\UpdateZoneRequest;
use Modules\Iplaces\Repositories\ZoneRepository;

class ZoneController extends AdminBaseController
{
    /**
     * @var ZoneRepository
     */
    private $zone;

    public function __construct(ZoneRepository $zone)
    {
        parent::__construct();

        $this->zone = $zone;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $zones = $this->zone->paginate(20);

        return view('iplaces::admin.zones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $zones = $this->zone->paginate(20);

        return view('iplaces::admin.zones.create', compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateZoneRequest $request): Response
    {//dd($request);
        try {
            $this->zone->create($request->all());

            return redirect()->route('admin.iplaces.zone.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::zones.title.zones')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::zones.title.zones')]))->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone): Response
    {//dd($zone);
        $zones = $this->zone->paginate(20);

        return view('iplaces::admin.zones.edit', compact('zone', 'zones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Zone $zone, UpdateZoneRequest $request): Response
    {//dd($zone);
        try {
            if (isset($request['options'])) {
                $options = (array) $request['options'];
            } else {
                $options = [];
            }
            $request['options'] = json_encode($options);
            $this->zone->update($zone, $request->all());

            return redirect()->route('admin.iplaces.zone.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::zones.title.zones')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::zones.title.zones')]))->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone): Response
    {
        try {
            $this->zone->destroy($zone);

            return redirect()->route('admin.iplaces.zone.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::zones.title.zones')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::zones.title.zones')]));
        }
    }
}
