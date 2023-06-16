<?php

namespace Modules\Ilocations\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ZoneTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'countryId' => $this->when($this->country_id, $this->country_id),
            'provinceId' => $this->when($this->province_id, $this->province_id),
            'cityId' => $this->when($this->city_id, $this->city_id),
            'country' => new CountryTransformer($this->whenLoaded('country')),
            'city' => new CityTransformer($this->whenLoaded('city')),
            'province' => new ProvinceTransformer($this->whenLoaded('province')),
        ];

        return $data;
    }
}
