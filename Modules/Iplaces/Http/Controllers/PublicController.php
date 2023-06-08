<?php

namespace Modules\Iplaces\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iplaces\Repositories\CategoryRepository;
use Modules\Iplaces\Repositories\PlaceRepository;
use Modules\Iplaces\Repositories\ScheduleRepository;
use Modules\Iplaces\Repositories\ServiceRepository;
use Modules\Iplaces\Repositories\ZoneRepository;
use Modules\Ilocations\Repositories\CityRepository;
use Route;

class PublicController extends BasePublicController
{

    public $place;
    public $category;
    public $service;
    public $zone;
    public $schedule;
    public $city;

    public function __construct(PlaceRepository $place, CategoryRepository $category, CityRepository $city, ServiceRepository $service, ZoneRepository $zone, ScheduleRepository $schedule)
    {
        parent::__construct();
        $this->place = $place;
        $this->category = $category;
        $this->service = $service;
        $this->zone = $zone;
        $this->schedule = $schedule;
        $this->city=$city;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index($slugCategory = null, Request $request)
    {
        $category = null;
        $paramsCat = [
            "include" => ["*"],
            "take" => false,
            "filter" => [
                "field" => "slug"
            ],
        ];

        $paramsCat = json_decode(json_encode($paramsCat));

        if($slugCategory)
            $category = $this->category->getItem($slugCategory, $paramsCat);

        $params = [
          "include" => ["categories","city","zone","schedules","services", "translations"],
          "take" => false,
          "filter" => [
              "category" => $category->id ?? null
          ],
        ];

        $params = json_decode(json_encode($params));

        $places = $this->place->getItemsBy($params);

        $tpl = 'iplaces::frontend.index';
        $ttpl = 'iplaces.index';

        if (view()->exists($ttpl)) $tpl = $ttpl;

        Return view($tpl, compact('places'));

    }

    public function show($slugCategory, $slugPlace)
    {

        $paramsCat = [
            "include" => ["*"],
            "take" => false,
            "filter" => [
                "field" => "slug"
            ],
        ];

        $paramsCat = json_decode(json_encode($paramsCat));

        $params = [
            "include" => ["categories","city","zone","schedules","services", "translations", "site"],
            "take" => false,
            "filter" => [
                "field" => "slug"
            ],
        ];

        $params = json_decode(json_encode($params));

        $category = $this->category->getItem($slugCategory,$paramsCat);
        $place = $this->place->getItem($slugPlace, $params);
        if ($place->category->id == $category->id) {
            $tpl = 'iplaces::frontend.show';
            $ttpl = 'iplaces.show';

            if (view()->exists($ttpl)) $tpl = $ttpl;

            Return view($tpl, compact('place','category'));
        }

        return abort(404);


    }
}
