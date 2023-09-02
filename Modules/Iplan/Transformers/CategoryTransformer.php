<?php

namespace Modules\Iplan\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'description' => $this->when($this->description, $this->description),
            'slug' => $this->when($this->slug, $this->slug),
            'status' => $this->status ? '1' : '0',
            'plans' => PlanTransformer::collection($this->whenLoaded('plans')),
            'parent' => new CategoryTransformer($this->whenLoaded('parent')),
            'parentId' => $this->when($this->parent_id, $this->parent_id),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
        ];

        return $data;
    }//toArray()
}
