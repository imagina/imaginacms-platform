<?php

namespace Modules\Iplan\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EntityPlanTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'module' => $this->when($this->module, $this->module),
            'entity' => $this->when($this->entity, $this->entity),
            'entityName' => $this->when($this->entity_name, $this->entity_name),
            'status' => $this->status ?? 0,
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),

        ];

        return $data;
    }//toArray()
}
