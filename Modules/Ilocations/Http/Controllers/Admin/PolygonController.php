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
     *
     * @return Response
     */
    public function index(): Response
    {
        //$polygons = $this->polygon->all();

        return view('ilocations::admin.polygons.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('ilocations::admin.polygons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreatePolygonRequest $request): Response
    {
        $this->polygon->create($request->all());

        return redirect()->route('admin.ilocations.polygon.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ilocations::polygons.title.polygons')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Polygon $polygon): Response
    {
        return view('ilocations::admin.polygons.edit', compact('polygon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Polygon $polygon, UpdatePolygonRequest $request): Response
    {
        $this->polygon->update($polygon, $request->all());

        return redirect()->route('admin.ilocations.polygon.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ilocations::polygons.title.polygons')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Polygon $polygon): Response
    {
        $this->polygon->destroy($polygon);

        return redirect()->route('admin.ilocations.polygon.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ilocations::polygons.title.polygons')]));
    }
}
