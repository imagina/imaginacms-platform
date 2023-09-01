<?php

namespace Modules\Ievent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iteam\Transformers\SimpleTeamTransformer;

class EventPublicTransformer extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'slug' => $this->when($this->slug, $this->slug),
            'date' => substr($this->date, 0, 10).' '.$this->hour,
            'hour' => $this->when($this->hour, $this->hour),
            'description' => $this->description,
            'mainImage' => $this->main_image,
            'categoryId' => $this->when($this->category_id, $this->category_id),
            'placeId' => $this->when($this->place_id, $this->place_id),
            'team' => new SimpleTeamTransformer($this->whenLoaded('team')),
        ];

        return $data;
    }
}
