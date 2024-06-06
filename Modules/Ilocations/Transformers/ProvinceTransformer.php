<?php

namespace Modules\Ilocations\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProvinceTransformer extends Resource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'name'=> $this->when($this->name,$this->name),
      'iso2' => $this->when($this->iso_2, $this->iso_2),
      'callingCode' => $this->when($this->calling_code, $this->calling_code),
      'countryId' => $this->when($this->country_id, $this->country_id),
      'country' => new CountryTransformer($this->whenLoaded('country')),
      'cities' => CityTransformer::collection($this->whenLoaded('cities')),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'createdAt' => $this->when($this->created_at, $this->created_at),
    ];

    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as $lang => $value) {
        $data[$lang]['name'] = $this->hasTranslation($lang) ? $this->translate("$lang")['name'] : '';
      }
    }

    return $data;
  }
}