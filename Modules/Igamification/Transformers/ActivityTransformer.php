<?php

namespace Modules\Igamification\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Iforms\Transformers\FormTransformer;
use Modules\Igamification\Entities\Type;

class ActivityTransformer extends CrudResource
{
  /**
   * Method to merge values with response
   *
   * @return array
   */
  public function modelAttributes($request)
  {
    //Get request Filters
    $filter = json_decode($request->filter);

    //Instance data
    $data = [
      'statusName' => $this->statusName,
      'type' => $this->type ?? Type::DEFAULT_TYPE,
      'typeName' => $this->typeName,
      'form' => null,
      'formId' => null
    ];

    // esta sección de código se agregó porque el formeable empezó a dar problemas cuando se implementó el tenant
    // la idea es que los formularios pertenezcan a un tenant también pero en el caso del formulario que pertenece al
    // registro que es un formulario central no llega con el trait porque el trait utiliza una relación morphMany que
    // ejecuta el scope del Tenant y no hay forma de evitarlo, por eso se realizó esta adaptación: se busca el id del
    // formulario asociado en la tabla formeable y luego se busca el objeto completo pero a través del repositorio
    if ($this->type == Type::INTERNAL_FORM) {
      $formRepository = app("Modules\Iforms\Entities\Form");
      $form = $formRepository->where('id', function ($subQ) {
        $subQ->from('iforms__formeable')
          ->select(['form_id'])
          ->where("formeable_type", "Modules\\Igamification\\Entities\\Activity")
          ->where("formeable_id", $this->id)
          ->first();
      })->with('translations', 'fields')->first();

      //Instance data
      $data = array_merge($data, [
        'form' => isset($form->id) ? new FormTransformer($form) : null,
        'formId' => $form->id ?? null,
      ]);
    }

    if (isset($filter->validateComplete)) {
      $user = \Auth::user();
      if ($user) {
        $userId = $user->id;
        $user = $this->users->where('id', $userId)->first();
        $data['userId'] = $userId;
        $data['userCompleted'] = $user ? true : false;
      } else {
        $data['userId'] = null;
        $data['userCompleted'] = false;
      }
    }

    //Response
    return $data;
  }
}
