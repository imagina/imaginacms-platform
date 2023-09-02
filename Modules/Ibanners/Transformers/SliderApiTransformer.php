<?php

namespace Modules\Ibanners\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderApiTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'caption' => $this->caption,
            'customHtml' => $this->custom_html,
            'imageUrl' => $this->getImageUrl(),
        ];
    }
}
