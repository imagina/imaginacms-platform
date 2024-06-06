<?php

namespace Modules\Slider\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;

class SliderApiTransformer extends Resource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'systemName' => $this->system_name,
      'active' => $this->active ? 1 : 0,
      'createdAt' => $this->created_at,
      'options' => $this->options,
      'slides' => SlideApiTransformer::collection($this->slides),
    ];
  }
}
