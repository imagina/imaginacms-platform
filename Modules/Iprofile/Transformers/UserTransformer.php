<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Ihelpers\Http\Controllers\Api\PermissionsApiController;
use Modules\Ihelpers\Http\Controllers\Api\SettingsApiController;
use Modules\Isite\Transformers\OrganizationTransformer;

class UserTransformer extends JsonResource
{
    public function toArray($request)
    {
        $this->permissionsApiController = new PermissionsApiController();
        $this->settingsApiController = new SettingsApiController();
        $mainImage = $this->fields ? $this->fields->where('name', 'mainImage')->first() : null;
        $contacts = $this->fields ? $this->fields->where('name', 'contacts')->first() : null;
        $socialNetworks = $this->fields ? $this->fields->where('name', 'socialNetworks')->first() : null;
        $defaultImage = \URL::to('/modules/iprofile/img/default.jpg');
        //Get settings
        $settings = json_decode(json_encode(SettingTransformer::collection($this->settings ?? collect([]))));
        $settingsResponse = [];
        foreach ($settings as $setting) {
            $settingsResponse[$setting->value->name ?? $setting->name] = $setting->value->value ?? $setting->value;
        }

        $data = [
            'id' => $this->when($this->id, $this->id),
            'firstName' => $this->when($this->first_name, $this->first_name),
            'lastName' => $this->when($this->last_name, $this->last_name),
            'fullName' => trim($this->present()->fullname),
            'isActivated' => $this->isActivated() ? '1' : '0',
            'email' => $this->when($this->email, $this->email),
            'permissions' => $this->permissions ?? [],
            'idOld' => $this->when($this->id_old, $this->id_old),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'lastLoginDate' => $this->when($this->last_login, $this->last_login),
            'userName' => $this->when($this->user_name, $this->user_name),

            'smallImage' => isset($mainImage->value) ?
              str_replace('.jpg', '_smallThumb.jpg?'.now(), $mainImage->value) : $defaultImage,
            'mediumImage' => isset($mainImage->value) ?
              str_replace('.jpg', '_mediumThumb.jpg?'.now(), $mainImage->value) : $defaultImage,
            'mainImage' => isset($mainImage->value) ? $mainImage->value.'?'.now() : $defaultImage,

            'contacts' => isset($contacts->value) ? new FieldTransformer($contacts) : ['name' => 'contacts', 'value' => []],
            'socialNetworks' => isset($socialNetworks->value) ? new FieldTransformer($socialNetworks) : ['name' => 'socialNetworks', 'value' => []],

            'departments' => DepartmentTransformer::collection($this->whenLoaded('departments')),
            'organizations' => OrganizationTransformer::collection($this->whenLoaded('organizations')),
            'settings' => $settingsResponse, //SettingTransformer::collection($this->whenLoaded('settings')),
            'fields' => FieldTransformer::collection($this->whenLoaded('fields')),
            'addresses' => AddressTransformer::collection($this->whenLoaded('addresses')),
            'roles' => RoleTransformer::collection($this->whenLoaded('roles')),

            'allPermissions' => $this->relationLoaded('roles') ? $this->permissionsApiController->getAll(['userId' => $this->id]) : [],
            'allSettings' => $this->relationLoaded('roles') ? $this->settingsApiController->getAll(['userId' => $this->id]) : [],
        ];

        $customUserIncludes = config('asgard.iprofile.config.customUserIncludes');

        foreach ($customUserIncludes as $include => $customUserInclude) {
            if ($customUserInclude['multiple']) {
                $data[$include] = $customUserInclude['path']::collection($this->whenLoaded($include));
            } else {
                $data[$include] = new $customUserInclude['path']($this->whenLoaded($include));
            }
        }

        return $data;
    }
}
