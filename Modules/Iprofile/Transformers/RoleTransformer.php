<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Modules\Iprofile\Entities\Role;

class RoleTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {
    $role = Role::find($this->id);
    $settings = $role->settings()->get();
    //Get settings
    $settings = json_decode(json_encode(SettingTransformer::collection($settings)));
    $settingsResponse = [];
    foreach ($settings as $setting) $settingsResponse[$setting->name] = $setting->value;

    return [
      'id' => $this->when($this->id, $this->id),
      'name' => $this->when($this->name, $this->name),
      'slug' => $this->when($this->slug, $this->slug),
      'permissions' => $this->permissions ?? (object)[],
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'settings' => (object)$settingsResponse,
      'users' => UserTransformer::collection($this->whenLoaded('users'))
    ];
  }
}
