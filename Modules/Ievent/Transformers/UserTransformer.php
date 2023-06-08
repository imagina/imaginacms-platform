<?php

namespace Modules\Iteam\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Cartalyst\Sentinel\Activations\EloquentActivation as Activation;
use Modules\Iprofile\Entities\Role;
use Modules\Iprofile\Entities\UserDepartment;
use Modules\Iprofile\Transformers\AddressTransformer;
use Modules\Iprofile\Transformers\FieldTransformer;
use Modules\Iprofile\Transformers\RoleTransformer;
use Modules\Iprofile\Transformers\SettingTransformer;

class UserTransformer extends JsonResource
{
  public function toArray($request)
  {
    $smallImage = $this->fields()->where('name','smallImage')->first();
    $mediumImage = $this->fields()->where('name','mediumImage')->first();
    $mainImage = $this->fields()->where('name','mainImage')->first();
    $contacts = $this->fields()->where('name','contacts')->first();
    $socialNetworks = $this->fields()->where('name','socialNetworks')->first();
    $defaultImage = \URL::to('/modules/iprofile/img/default.jpg');

    $filter = json_decode($request->filter);
    $setting = json_decode($request->input('setting'));
    $userDepartment = UserDepartment::where("user_id", $this->id)
      ->where("department_id", $filter->departmentId)->first();
    $role =  Role::find($userDepartment->role_id);

    $item = [
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
        str_replace('.jpg', '_smallThumb.jpg?' . strtotime($this->updated_at), $mainImage->value) : $defaultImage,
      'mediumImage' => isset($mainImage->value) ?
        str_replace('.jpg', '_mediumThumb.jpg?' . strtotime($this->updated_at), $mainImage->value) : $defaultImage,
      'mainImage' => isset($mainImage->value) ? $mainImage->value . '?' . strtotime($this->updated_at) : $defaultImage,

      'contacts' => isset($contacts->value) ? new FieldTransformer($contacts) : ["name"=>"contacts","value" =>[]],
      'socialNetworks' => isset($socialNetworks->value) ? new FieldTransformer($socialNetworks) : ["name"=>"socialNetworks","value" =>[]],
      "role" => new RoleTransformer($role),
      //'departments' => DepartmentTransformer::collection($this->whenLoaded('departments')),
      'settings' => SettingTransformer::collection($this->whenLoaded('settings')),
      'fields' => FieldTransformer::collection($this->whenLoaded('fields')),
      'addresses' => AddressTransformer::collection($this->whenLoaded('addresses')),

    ];


    return $item;
  }
}
