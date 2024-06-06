<?php


namespace Modules\Ilocations\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GeozoneTransformer extends Resource
{

  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'name'=> $this->when($this->name, $this->name),
      'description' => $this->when($this->description, $this->description),
      'countries' => CountryTransformer::collection($this->whenLoaded('countries')),
      'cities' => CityTransformer::collection($this->whenLoaded('cities')),
      'provinces' => ProvinceTransformer::collection($this->whenLoaded('provinces')),
      'polygons' => PolygonTransformer::collection($this->whenLoaded('polygons')),
      'neighborhoods' => PolygonTransformer::collection($this->whenLoaded('neighborhoods')),
    ];

    return $data;
  }

}