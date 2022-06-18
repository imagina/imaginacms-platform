<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Modules\Iprofile\Entities\Role;
use Modules\Iforms\Transformers\FormTransformer;

class RoleTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {
    $roleRepository = app("Modules\Iprofile\Repositories\RoleApiRepository");
    $role = $roleRepository->getItem($this->id);
    $settings = $role->settings()->get();
    //Get settings
    $settings = json_decode(json_encode(SettingTransformer::collection($settings)));
    $settingsResponse = [];
    foreach ($settings as $setting) $settingsResponse[$setting->name] = $setting->value;
  
  // esta sección de código se agregó porque el formeable empezó a dar problemas cuando se implementó el tenant
    // la idea es que los formularios pertenezcan a un tenant también pero en el caso del formulario que pertenece al
    // registro que es un formulario central no llega con el trait porque el trait utiliza una relación morphMany que
    // ejecuta el scope del Tenant y no hay forma de evitarlo, por eso se realizó esta adaptación: se busca el id del
    // formulario asociado en la tabla formeable y luego se busca el objeto completo pero a través del repositorio
    $formRepository = app("Modules\Iforms\Repositories\FormRepository");
    $formeable = \DB::table("iforms__formeable")
      ->where("formeable_type","Modules\\Iprofile\\Entities\\Role")
      ->where("formeable_id",$this->id)
      ->first();

    $form = isset($formeable->form_id) ? $formRepository->getItem($formeable->form_id) : null;
    
    return [
      'id' => $this->when($this->id, $this->id),
      'name' => $this->when($this->name, $this->name),
      'slug' => $this->when($this->slug, $this->slug),
      'permissions' => $this->permissions ?? (object)[],
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'settings' => (object)$settingsResponse,
      'form' => isset($form->id) ? new FormTransformer($form): null,
      'formId' => $form->id ?? null,
      'users' => UserTransformer::collection($this->whenLoaded('users'))
    ];
  }
}
