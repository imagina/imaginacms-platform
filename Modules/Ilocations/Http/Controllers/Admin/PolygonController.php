<?php

namespace Modules\Ilocations\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ilocations\Entities\Polygon;
use Modules\Ilocations\Http\Requests\CreatePolygonRequest;
use Modules\Ilocations\Http\Requests\UpdatePolygonRequest;
use Modules\Ilocations\Repositories\PolygonRepository;

class PolygonController extends AdminBaseController
{
    /**
     * @var PolygonRepository
     */
    private $polygon;

    public function __construct(PolygonRepository $polygon)
    {
        parent::__construct();

        $this->polygon = $polygon;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$polygons = $this->polygon->all();

        return view('ilocations::admin.polygons.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ilocations::admin.polygons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePolygonRequest $request)
    {
        $this->polygon->create($request->all());

        return redirect()->route('admin.ilocations.polygon.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ilocations::polygons.title.polygons')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Polygon $polygon)
    {
        return view('ilocations::admin.polygons.edit', compact('polygon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Polygon $polygon, UpdatePolygonRequest $request)
    {
        $this->polygon->update($polygon, $request->all());

        return redirect()->route('admin.ilocations.polygon.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ilocations::polygons.title.polygons')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Polygon $polygon)
    {
        $this->polygon->destroy($polygon);

        return redirect()->route('admin.ilocations.polygon.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ilocations::polygons.title.polygons')]));
    }
}
