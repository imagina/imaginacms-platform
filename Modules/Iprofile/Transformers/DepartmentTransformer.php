<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Ihelpers\Transformers\BaseApiTransformer;

class DepartmentTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {
    $settings = $this->settings()->get();
    return [
      'id' => $this->when($this->id, $this->id),
      'title' => $this->when($this->title, $this->title),
      'parentId' => $this->when(isset($this->parent_id), $this->parent_id),
      'options' => $this->when($this->options, $this->options),
      'users' => UserTransformer::collection($this->whenLoaded('users')),
      'parent' => new DepartmentTransformer($this->whenLoaded('parent')),
      'internal' => $this->when(isset($this->internal), $this->internal),
      'settings' => $settings ? SettingTransformer::collection($settings) : [],
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];
  }
}
