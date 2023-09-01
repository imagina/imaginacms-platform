<?php

namespace Modules\Icheckin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class JobTransformer extends JsonResource
{
    public function toArray($request): array
    {
        $item = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'status' => $this->when($this->status, $this->status),
        ];

        return $item;
    }
}
