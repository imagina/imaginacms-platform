<?php

namespace Modules\Iredirect\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RedirectApiTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'from' => $this->when($this->from, $this->from),
            'to' => $this->when($this->to, $this->to),
            'redirect_type' => $this->when($this->redirect_type, $this->redirect_type),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),

        ];

        return $data;
    }
}
