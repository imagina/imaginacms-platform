<?php

namespace Modules\Iforms\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeTransformer extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
        ];

        return $data;
    }
}
