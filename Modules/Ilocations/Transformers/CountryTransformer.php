<?php

namespace Modules\Ilocations\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CountryTransformer extends Resource
{
  public function toArray($request)
  {
    $data = [
      'id'=>$this->when($this->id,$this->id),
      'name'=> $this->when($this->name,$this->name),
      'fullName'=>$this->when($this->full_name,$this->full_name),
      'iso2'=>$this->when($this->iso_2,$this->iso_2),
      'status'=>$this->when($this->status,$this->status),
      'currency'=>$this->when($this->currency,$this->currency),
      'currencySymbol'=>$this->when($this->currency_symbol,$this->currency_symbol),
      'currencyCode'=>$this->when($this->currency_code,$this->currency_code),
      'currencySubUnit'=>$this->when($this->currency_sub_unit,$this->currency_sub_unit),
      'regionCode'=>$this->when($this->region_code,$this->region_code),
      'subRegionCode' => $this->when($this->sub_region_code,$this->sub_region_code),
      'countryCode'=>$this->when($this->country_code,$this->country_code),
      'iso3'=>$this->when($this->iso_3,$this->iso_3),
      'callingCode'=>$this->when($this->calling_code,$this->calling_code),
      'provinces'=> ProvinceTransformer::collection($this->whenLoaded('provinces')),
      'cities'=> CityTransformer::collection($this->whenLoaded('cities')),
      'updatedAt'=>$this->when($this->updated_at,$this->updated_at),
      'createdAt' => $this->when($this->created_at, $this->created_at),
    ];

    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as $lang => $value) {
        $data[$lang]['name'] = $this->hasTranslation($lang) ? $this->translate("$lang")['name'] : '';
        $data[$lang]['fullName'] = $this->hasTranslation($lang) ? $this->translate("$lang")['full_name'] : '';
      }
    }

    return $data;
  }
}