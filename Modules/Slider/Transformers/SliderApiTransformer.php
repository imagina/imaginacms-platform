<?php

namespace Modules\Slider\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Isite\Transformers\RevisionTransformer;

class SliderApiTransformer extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'systemName' => $this->system_name,
      'active' => $this->active ? 1 : 0,
      'createdAt' => $this->created_at,
      'options' => $this->when($this->options, $this->options),
      'slides' => SlideApiTransformer::collection($this->slides),
      'revisions' => RevisionTransformer::collection($this->whenLoaded('revisions')),
    ];
  }
}
