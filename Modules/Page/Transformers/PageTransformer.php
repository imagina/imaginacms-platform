<?php

namespace Modules\Page\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PageTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'is_home' => $this->resource->is_home,
            'template' => $this->resource->template,
            'options' => $this->resource->options,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'translations' => [
                'title' => optional($this->resource->translate(locale()))->title,
                'slug' => optional($this->resource->translate(locale()))->slug,
                'status' => optional($this->resource->translate(locale()))->status,
            ],
            'urls' => [
                'delete_url' => route('api.page.page.destroy', $this->resource->id),
            ],
        ];
    }
}
