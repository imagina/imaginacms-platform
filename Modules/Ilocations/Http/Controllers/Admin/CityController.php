<?php

namespace Modules\Ilocations\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ilocations\Entities\City;
use Modules\Ilocations\Http\Requests\CreateCityRequest;
use Modules\Ilocations\Http\Requests\UpdateCityRequest;
use Modules\Ilocations\Repositories\CityRepository;

class CityController extends AdminBaseController
{
    /**
     * @var CityRepository
     */
    private $city;

    public function __construct(CityRepository $city)
    {
        parent::__construct();

        $this->city = $city;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$cities = $this->city->all();

        return view('ilocations::admin.cities.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ilocations::admin.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateCityRequest $request)
    {
        $this->city->create($request->all());

        return redirect()->route('admin.ilocations.city.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ilocations::cities.title.cities')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(City $city)
    {
        return view('ilocations::admin.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(City $city, UpdateCityRequest $request)
    {
        $this->city->update($city, $request->all());

        return redirect()->route('admin.ilocations.city.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ilocations::cities.title.cities')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(City $city)
    {
        $this->city->destroy($city);

        return redirect()->route('admin.ilocations.city.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ilocations::cities.title.cities')]));
    }
}
