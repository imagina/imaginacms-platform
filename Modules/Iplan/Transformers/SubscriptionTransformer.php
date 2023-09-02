<?php

namespace Modules\Iplan\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'name' => $this->when($this->name, $this->name),
            'description' => $this->when($this->description, $this->description),
            'categoryName' => $this->when($this->category_name, $this->category_name),
            'entityId' => $this->when($this->entity_id, $this->entity_id),
            'entity' => $this->when($this->entity, $this->entity),
            'entityName' => $this->entityData ? ($this->entityData->title ?? $this->entityData->name ?? $this->entityData->present()->fullName) : '',
            'status' => $this->status ?? '0',
            'statusName' => $this->when($this->statusName, $this->statusName),
            'planId' => $this->plan_id,
            'startDate' => $this->when($this->start_date, $this->start_date),
            'endDate' => $this->when($this->end_date, $this->end_date),
            'limits' => SubscriptionLimitTransformer::collection($this->whenLoaded('limits')),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
        ];

        return $data;
    }//toArray()
}
