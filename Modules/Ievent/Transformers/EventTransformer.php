<?php

namespace Modules\Ievent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Modules\Iplaces\Transformers\PlaceTransformer;
use Modules\Iplaces\Transformers\RouteTransformer;
use Modules\Iprofile\Transformers\DepartmentTransformer;
use Modules\Iprofile\Transformers\UserTransformer;

class EventTransformer extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->when($this->id, $this->id),
      'title' => $this->when($this->title, $this->title),
      'slug' => $this->when($this->slug, $this->slug),
      'date' => substr($this->date, 0, 10) . ' ' . $this->hour,
      'hour' => $this->when($this->hour, $this->hour),
      'options' => $this->options,
      'isPublic' => $this->is_public . "",
      'description' => $this->description,
      'status' => (string)$this->status,
      'statusName' => $this->status_name,
      'categoryId' => $this->when($this->category_id, $this->category_id),
      'placeId' => $this->when($this->place_id, $this->place_id),
      'userId' => $this->when($this->user_id, $this->user_id),
      'departmentId' => $this->when($this->department_id, $this->department_id),
      'placeId' => $this->when($this->place_id, $this->place_id),
      'user' => new UserTransformer($this->whenLoaded('user')),
      'place' => new PlaceTransformer($this->whenLoaded('place')),
      'department' => new DepartmentTransformer($this->whenLoaded('department')),
      'category' => new CategoryTransformer($this->whenLoaded('category')),
      'attendants' => AttendantTransformer::collection($this->whenLoaded('attendants')),
      'lastAttendants' => AttendantTransformer::collection($this->last_attendants),
      'attendantsCount' => $this->attendants_count,
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'commentsCount' => $this->comments_count,
      'mediaFiles' => $this->mediaFiles(),
    ];
  }
}
