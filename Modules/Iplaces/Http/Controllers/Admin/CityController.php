<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ilocations\Repositories\ProvinceRepository;
use Modules\Iplaces\Entities\City;
use Modules\Iplaces\Http\Requests\CreateCityRequest;
use Modules\Iplaces\Repositories\CityRepository;

class CityController extends AdminBaseController
{
    /**
     * @var CityRepository
     */
    private $city;

    private $province;

    public function __construct(CityRepository $city, ProvinceRepository $province)
    {
        parent::__construct();

        $this->city = $city;
        $this->province = $province;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $cities = $this->city->all();

        return view('iplaces::admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $filter = json_decode(json_encode(['country_id' => 48]));
        $provinces = $this->province->index(null, null, $filter, [], []);

        return view('iplaces::admin.cities.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCityRequest $request): Response
    {
        try {
            $this->city->create($request->all());

            return redirect()->route('admin.iplaces.city.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::cities.title.cities')]));
        } catch (\Exception $e) {
            \Log::error($e);

            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::cities.title.cities')]))->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city): Response
    {
        $filter = json_decode(json_encode(['country_id' => 48]));
        $provinces = $this->province->index(null, null, $filter, [], []);

        return view('iplaces::admin.cities.edit', compact('city', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(City $city, Request $request): Response
    {
        $this->city->update($city, $request->all());

        return redirect()->route('admin.iplaces.city.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::cities.title.cities')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city): Response
    {
        $this->city->destroy($city);

        return redirect()->route('admin.iplaces.city.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::cities.title.cities')]));
    }
}
