<?php

namespace Modules\Tag\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TagTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'slug' => $this->resource->slug,
            'name' => $this->resource->name,
        ];
    }
}
