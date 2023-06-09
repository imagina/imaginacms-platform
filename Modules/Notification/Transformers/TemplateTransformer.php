<?php

namespace Modules\Notification\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'name' => $this->when($this->name, $this->name),
            'view' => $this->when($this->view, $this->view),

            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
        ];

        return $data;
    }
}
