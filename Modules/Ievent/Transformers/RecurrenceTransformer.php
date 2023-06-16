<?php

namespace Modules\Ievent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\DepartmentTransformer;
use Modules\Iprofile\Transformers\UserTransformer;

class RecurrenceTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->when($this->id, $this->id),
            'relatedName' => $this->when($this->related_name, $this->related_name),
            'information' => $this->when($this->information, $this->information),
            'hour' => $this->when($this->hour, $this->hour),
            'isPublic' => $this->when($this->is_public, $this->is_public),
            'description' => $this->when($this->description, $this->description),
            'mainImage' => $this->main_image,
            'categoryId' => $this->when($this->category_id, $this->category_id),
            'placeId' => $this->when($this->place_id, $this->place_id),
            'userId' => $this->when($this->user_id, $this->user_id),
            'departmentId' => $this->when($this->department_id, $this->department_id),
            'user' => new UserTransformer($this->whenLoaded('user')),
            'department' => new DepartmentTransformer($this->whenLoaded('department')),
            'category' => new CategoryTransformer($this->whenLoaded('category')),
            'recurrenceDays' => new RecurrenceDayTransformer($this->whenLoaded('recurrenceDays')),
        ];
    }
}
