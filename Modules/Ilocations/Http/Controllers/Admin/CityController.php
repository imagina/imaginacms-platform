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
     */
    public function index(): Response
    {
        //$cities = $this->city->all();

        return view('ilocations::admin.cities.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('ilocations::admin.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCityRequest $request): Response
    {
        $this->city->create($request->all());

        return redirect()->route('admin.ilocations.city.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ilocations::cities.title.cities')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city): Response
    {
        return view('ilocations::admin.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(City $city, UpdateCityRequest $request): Response
    {
        $this->city->update($city, $request->all());

        return redirect()->route('admin.ilocations.city.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ilocations::cities.title.cities')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city): Response
    {
        $this->city->destroy($city);

        return redirect()->route('admin.ilocations.city.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ilocations::cities.title.cities')]));
    }
}
