<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Ihelpers\Http\Controllers\Api\PermissionsApiController;
use Modules\Ihelpers\Http\Controllers\Api\SettingsApiController;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Cartalyst\Sentinel\Activations\EloquentActivation as Activation;

class UserTransformer extends Resource
{
  public function toArray($request)
  {
    $this->permissionsApiController = new PermissionsApiController();
    $this->settingsApiController = new SettingsApiController();
    $smallImage = $this->fields()->where('name','smallImage')->first();
    $mediumImage = $this->fields()->where('name','mediumImage')->first();
    $mainImage = $this->fields()->where('name','mainImage')->first();
    $contacts = $this->fields()->where('name','contacts')->first();
    $socialNetworks = $this->fields()->where('name','socialNetworks')->first();
    $defaultImage = \URL::to('/modules/iprofile/img/default.jpg');

    $data = [
      'id' => $this->when($this->id, $this->id),
      'firstName' => $this->when($this->first_name, $this->first_name),
      'lastName' => $this->when($this->last_name, $this->last_name),
      'fullName' => $this->when(($this->first_name && $this->last_name), trim($this->present()->fullname)),
      'activated' => $this->isActivated() ? 1 : 0,
      'email' => $this->when($this->email, $this->email),
      'permissions' => $this->permissions ?? [],
      'idOld' => $this->when($this->id_old, $this->id_old),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'lastLoginDate' => $this->when($this->last_login, $this->last_login),

      'smallImage' => isset($mainImage->value) ?
        str_replace('.jpg', '_smallThumb.jpg?' . now(), $mainImage->value) : $defaultImage,
      'mediumImage' => isset($mainImage->value) ?
        str_replace('.jpg', '_mediumThumb.jpg?' . now(), $mainImage->value) : $defaultImage,
      'mainImage' => isset($mainImage->value) ? $mainImage->value . '?' . now() : $defaultImage,

      'contacts' => isset($contacts->value) ? new FieldTransformer($contacts) : ["name"=>"contacts","value" =>[]],
      'socialNetworks' => isset($socialNetworks->value) ? new FieldTransformer($socialNetworks) : ["name"=>"socialNetworks","value" =>[]],

      'departments' => DepartmentTransformer::collection($this->whenLoaded('departments')),
      'settings' => SettingTransformer::collection($this->whenLoaded('settings')),
      'fields' => FieldTransformer::collection($this->whenLoaded('fields')),
      'addresses' => AddressTransformer::collection($this->whenLoaded('addresses')),
      'roles' => RoleTransformer::collection($this->whenLoaded('roles')),

      'allPermissions' => $this->permissionsApiController->getAll(['userId' => $this->id]),
      'allSettings' => $this->settingsApiController->getAll(['userId' => $this->id]),
    ];

    $customUserIncludes = config('asgard.iprofile.config.customUserIncludes');

    foreach ($customUserIncludes as $include=>$customUserInclude){
      if($customUserInclude['multiple']){
        $data[$include] = $customUserInclude['path']::collection($this->whenLoaded($include));
      }else{
        $data[$include] = new $customUserInclude['path']($this->whenLoaded($include));
      }
    }

    return $data;

  }
}
