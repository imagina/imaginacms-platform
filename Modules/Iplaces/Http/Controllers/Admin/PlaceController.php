<?php

namespace Modules\Iplaces\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Iplaces\Entities\Category;
use Modules\Iplaces\Entities\Place;
use Modules\Iplaces\Http\Requests\CreatePlaceRequest;
use Modules\Iplaces\Http\Requests\UpdatePlaceRequest;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Iplaces\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Repositories\ZoneRepository;
use Modules\Iplaces\Repositories\ServiceRepository;
use Modules\User\Repositories\UserRepository;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Ilocations\Repositories\CityRepository;
use Modules\Iplaces\Repositories\CityRepository as SiteRepository;
use Modules\Ilocations\Repositories\ProvinceRepository;
use Modules\Ilocations\Repositories\EloquentCityRepository;
use Modules\Iplaces\Repositories\ScheduleRepository;
use Modules\Iplaces\Entities\Weather;
use Modules\Iplaces\Entities\Gama;
use Modules\Iplaces\Entities\StatusYN;
use Modules\Iplaces\Repositories\SpaceRepository;

class PlaceController extends AdminBaseController
{
    /**
     * @var PlaceRepository
     */
    private $place;
    public $status;
    private $category;
    private $user;
    private $zone;
    private $service;
    private $city;
    private $site;
    private $province;
    private $schedule;
    private $weather;
    private $gama;
    private $statusyn;
    private $space;

    public function __construct(
        PlaceRepository $place, 
        Status $status, 
        CategoryRepository $category, 
        UserRepository $user, 
        ZoneRepository $zone, 
        ServiceRepository $service, 
        CityRepository $city,
        SiteRepository $site,
        ProvinceRepository $province, 
        ScheduleRepository $schedule, 
        Weather $weather,
        Gama $gama,
        StatusYN $statusyn,
        SpaceRepository $space
    ){
        parent::__construct();

        $this->place = $place;
        $this->status = $status;
        $this->category = $category;
        $this->user = $user;
        $this->zone = $zone;
        $this->service = $service;
        $this->city = $city;
        $this->site = $site;
        $this->province = $province;
        $this->schedule = $schedule;
        $this->weather = $weather;
        $this->gama = $gama;
        $this->statusyn = $statusyn;
        $this->space = $space;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $places = $this->place->all();

        return view('iplaces::admin.places.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $statuses = $this->status->lists();
        $categories = $this->category->all();
        $users = $this->user->all();
        $zones = $this->zone->all();
        $services = $this->service->whereType(0);
        $servicesSecond = $this->service->whereType(1);
        $filter=json_decode(json_encode(['country_id'=>1]));
        $provinces = $this->province->index(null,null,$filter,[],[]);
        $schedules= $this->schedule->all();
        $weathers= $this->weather->lists();
        $sites = $this->site->all();
        $gamas = $this->gama->lists();
        $related=$this->place->all();
        $statusesyn = $this->statusyn->lists();
        $spaces = $this->space->all();

        return view('iplaces::admin.places.create', compact('categories','related', 'statuses', 'users', 'zones', 'services','servicesSecond','sites','provinces','schedules','weathers','gamas','statusesyn','spaces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePlaceRequest $request
     * @return Response
     */
    public function store(CreatePlaceRequest $request)
    {

        try {
            $this->place->create($request->all());
            return redirect()->route('admin.iplaces.place.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iplaces::places.title.places')]));
        } catch (\Exception $e) {
           
            //dd($e);
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::places.title.places')]))->withInput($request->all());

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Place $place
     * @return Response
     */
    public function edit(Place $place)
    {//dd($place->services);
        $statuses = $this->status->lists();
        $categories = $this->category->all();
        $users = $this->user->all();
        $zones = $this->zone->all();
        $services = $this->service->whereType(0);
        $servicesSecond = $this->service->whereType(1);
        $filter=json_decode(json_encode(['country_id'=>1]));
        $provinces = $this->province->index(null,null,$filter,[],[]);
        $sites=$this->site->all();
        $filter_city = json_decode(json_encode(['province_id'=>$place->province_id]));
        $cities=$this->city->index(null,null,$filter_city,[],[]);
        $schedules=$this->schedule->all();
        $weathers=$this->weather->lists();
        $related=$this->place->all();
        $gamas = $this->gama->lists();
        $statusesyn = $this->statusyn->lists();
        $spaces = $this->space->all();

        return view('iplaces::admin.places.edit', compact('place','related', 'cities','statuses', 'categories', 'users', 'zones', 'services','sites','provinces','schedules','weathers','gamas','statusesyn','spaces','servicesSecond'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Place $place
     * @param  UpdatePlaceRequest $request
     * @return Response
     */
    public function update(Place $place, CreatePlaceRequest $request)
    {//dd($request);
        try {
            if (isset($request['options'])) {
                $options = (array)$request['options'];
            } else {
                $options = array();
            }


            isset($request->mainimage) ? $options["mainimage"] = saveImage($request['mainimage'], "assets/iplaces/place/" . $place->id . ".jpg") : false;

            $request['options'] = json_encode($options);
            $this->place->update($place, $request->all());

            return redirect()->route('admin.iplaces.place.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iplaces::places.title.places')]));
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::places.title.places')]))->withInput($request->all());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Place $place
     * @return Response
     */
    public function destroy(Place $place)
    {
        try {
            $this->place->destroy($place);

            return redirect()->route('admin.iplaces.place.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iplaces::places.title.places')]));

        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iplaces::places.title.places')]));
        }

    }
    public function addPosts(Request $request,$place_id){

        if($request->relations_ids){

            $places = $this->business->getById($place_id);
            $places->relations()->syncWithoutDetaching($request->relations_ids);

        }

        return redirect()->route('admin.ibusiness.userbusiness.edit', [$places->id])
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ibusiness::userbusinesses.title.userbusinesses')]));

    }

    public function galleryStore(Request $request)
    {
        try{
            $original_filename = $request->file('file')->getClientOriginalName();

            $idplace = $request->input('idedit');
            $extension = $request->file('file')->getClientOriginalExtension();
            $allowedextensions = array('JPG', 'JPEG', 'PNG', 'GIF');

            if (!in_array(strtoupper($extension), $allowedextensions)) {
                return 0;
            }
            $disk = 'publicmedia';
            $image = \Image::make($request->file('file'));
            $name = Str::slug(str_replace('.' . $extension, '', $original_filename), '-');

            $image->resize(config('asgard.iplaces.config.imagesize.width'), config('asgard.iplaces.config.imagesize.height'), function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if (config('asgard.iplaces.config.watermark.activated')) {
                $image->insert(config('asgard.iplaces.config.watermark.url'), config('asgard.iplaces.config.watermark.position'), config('asgard.iplaces.config.watermark.x'), config('asgard.iplaces.config.watermark.y'));
            }
            $nameimag = $name . '.' . $extension;
            $destination_path = 'assets/iplaces/place/gallery/' . $idplace . '/' . $nameimag;

            \Storage::disk($disk)->put($destination_path, $image->stream($extension, '100'));

            return array('direccion' => $destination_path);
        }
        catch (\Exception $e){
            return $e->getMessage();
        }

    }

    public function galleryDelete(Request $request)
    {
        $disk = "publicmedia";
        $dirdata = $request->input('dirdata');
        \Storage::disk($disk)->delete($dirdata);
        return array('success' => true);
    }
}
