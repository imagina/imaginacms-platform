<?php

namespace Modules\Ilocations\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CityTransformer extends Resource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'name'=> $this->when($this->name, $this->name),
      'code' => $this->when($this->code, $this->code),
      'provinceId' => $this->when($this->province_id, $this->province_id),
      'countryId' => $this->when($this->country_id, $this->country_id),
      'province' => new ProvinceTransformer($this->whenLoaded('province')),
      'country' => new CountryTransformer($this->whenLoaded('country')),
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