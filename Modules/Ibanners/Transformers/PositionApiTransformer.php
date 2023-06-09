<?php

namespace Modules\Ibanners\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionApiTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->when($this->name, $this->name),
            'systemName' => $this->when($this->system_name, $this->system_name),
            'active' => $this->active == 1 ? 1 : 0,
            'options' => $this->when($this->options, $this->options),
            'createdAt' => $this->created_at,
            'showAsPopup' => $this->show_as_popup == 1 ? true : false,
            'banners' => BannerApiTransformer::collection($this->Banners),
        ];
    }
}
