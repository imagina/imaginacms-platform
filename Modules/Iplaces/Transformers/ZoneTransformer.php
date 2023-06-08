<?php

namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserProfileTransformer;

class ZoneTransformer extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'options' => $options,
            'createdAt' => ($this->created_at),
            'updatedAt' => ($this->updated_at)
        ];

       /* if (in_array('service',$includes)) {

            $data['service']= ServiceTransformers::collection($this->services);
        }
        return $data;
*/

    }


}