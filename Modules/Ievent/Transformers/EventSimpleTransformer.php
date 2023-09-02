<?php

namespace Modules\Ievent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EventSimpleTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'date' => substr($this->date, 0, 10).' '.$this->hour,
            'hour' => $this->when($this->hour, $this->hour),
            'options' => $this->when($this->options, $this->options),
            'isPublic' => $this->is_public.'',
            'description' => $this->description,
            'status' => $this->status,
            'statusName' => $this->status_name,
            'createdAt' => $this->when($this->created_at, $this->created_at),

        ];

        return $data;
    }
}
