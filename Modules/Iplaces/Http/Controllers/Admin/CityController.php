<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iplaces\Entities\City;
use Modules\Iplaces\Http\Requests\CreateCityRequest;
use Modules\Iplaces\Http\Requests\UpdateCityRequest;
use Modules\Iplaces\Repositories\CityRepository;
use Modules\Ilocations\Repositories\ProvinceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
     *
     * @return Response
     */
    public function index()
    {
        $cities = $this->city->all();

        return view('iplaces::admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $filter=json_decode(json_encode(['country_id'=>48]));
        $provinces = $this->province->index(null,null,$filter,[],[]);
        return view('iplaces::admin.cities.create',compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCityRequest $request
     * @return Response
     */
    public function store(CreateCityRequest $request)
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
     *
     * @param  City $city
     * @return Response
     */
    public function edit(City $city)
    {
        $filter=json_decode(json_encode(['country_id'=>48]));
        $provinces = $this->province->index(null,null,$filter,[],[]);
        return view('iplaces::admin.cities.edit', compact('city','provinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  City $city
     * @param  UpdateCityRequest $request
     * @return Response
     */
    public function update(City $city, Request $request)
    {
        $this->city->update($city, $request->all());

        return redirect()->route('admin.iplaces.city.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::cities.title.cities')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  City $city
     * @return Response
     */
    public function destroy(City $city)
    {
        $this->city->destroy($city);

        return redirect()->route('admin.iplaces.city.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::cities.title.cities')]));
    }
}
