<?php

namespace Modules\Ilocations\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ilocations\Entities\Geozones;
use Modules\Ilocations\Entities\GeozonesCountries;
use Modules\Ilocations\Http\Requests\CreateGeozonesRequest;
use Modules\Ilocations\Http\Requests\UpdateGeozonesRequest;
use Modules\Ilocations\Repositories\GeozonesRepository;
use Modules\Ilocations\Repositories\CountryRepository;
use Modules\Ilocations\Repositories\ProvinceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class GeozonesController extends AdminBaseController
{
    /**
     * @var GeozonesRepository
     */
    private $geozones;
  private $country;
  private $province;

    // public function __construct()
    public function __construct(
      GeozonesRepository $geozones,
      CountryRepository $country,
      ProvinceRepository $province)
    {
        parent::__construct();
  
      $this->geozones = $geozones;
      $this->country = $country;
      $this->province= $province;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $geozones = Geozones::all();
        return view('ilocations::admin.geozones.index', array('geozones'=>$geozones));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ilocations::admin.geozones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateGeozonesRequest $request
     * @return Response
     */
    public function store(CreateGeozonesRequest $request)
    {
      $geozone = $this->geozones->create($request->all());
      
      foreach($request->geozones as $geozonex){
        $geozoneRelation=new GeozonesCountries();
        $geozoneRelation->geozone_id=$geozone->id;
        $geozoneRelation->country_id = $this->country->findByIso2($geozonex['countryValue'])->id;
        $geozoneRelation->province_id = $geozonex['zoneValue'] ? $this->province->findByIso2($geozonex['zoneValue'])->id : null;
        $geozoneRelation->save();
      }
      return ['success'=>1,'message'=>trans('core::core.messages.resource created', ['name' => trans('ilocations::geozones.title.geozones')])];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Geozones $geozones
     * @return Response
     */
    public function edit(Geozones $geozones)
    {
      $geozoneRelation = GeozonesCountries::where('geozone_id',$geozones->id)->with(['country','province'])->get();
        return view('ilocations::admin.geozones.edit', compact('geozones','geozoneRelation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Geozones $geozones
     * @param  UpdateGeozonesRequest $request
     * @return Response
     */
    public function update(Geozones $geozones, UpdateGeozonesRequest $request)
    {
      $geozone = $this->geozones->update($geozones,$request->all());
      $geozoneRelation=GeozonesCountries::where('geozone_id',$geozones->id)->delete();
      foreach($request->geozones as $geozonex){
        $geozoneRelation=new GeozonesCountries();
        $geozoneRelation->geozone_id=$geozones->id;
        $geozoneRelation->country_id = $this->country->findByIso2($geozonex['countryValue'])->id;
        $geozoneRelation->province_id = $geozonex['zoneValue'] ? $this->province->findByIso2($geozonex['zoneValue'])->id : null;
        $geozoneRelation->save();
      }
      return ['success'=>1,'message'=>trans('core::core.messages.resource updated', ['name' => trans('ilocations::geozones.title.geozones')])];
        // return redirect()->route('admin.ilocations.geozones.index')
            // ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ilocations::geozones.title.geozones')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Geozones $geozones
     * @return Response
     */
    public function destroy(Geozones $geozones)
    {
        $geozoneRelation=GeozonesCountries::where('geozone_id',$geozones->id)->delete();
        $this->geozones->destroy($geozones);

        return redirect()->route('admin.ilocations.geozones.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ilocations::geozones.title.geozones')]));
    }
}
