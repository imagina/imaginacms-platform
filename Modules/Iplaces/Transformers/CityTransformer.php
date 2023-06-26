<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 10/10/2018
 * Time: 5:26 PM
 */

namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Ilocations\Transformers\ProvinceTransformer;

class CityTransformer extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'options' => $options,
            'createdAt' => ($this->created_at),
            'updatedAt' => ($this->updated_at),
        ];

        if (in_array('province', $includes)) {
            $data['province'] = new ProvinceTransformer($this->province);
        }

        if (in_array('places', $includes)) {
            $data['city'] = PlaceTransformer::collection($this->places);
        }

        return $data;
    }
}
