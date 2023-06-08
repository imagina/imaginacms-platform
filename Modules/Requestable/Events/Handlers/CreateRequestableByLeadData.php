<?php

namespace Modules\Requestable\Events\Handlers;

use Modules\Iforms\Events\LeadWasCreated;

class CreateRequestableByLeadData
{

  public function handle(LeadWasCreated $event)
  {
    $values = $event->entity->values;
    $formeableData = \DB::table('iforms__formeable')->where("form_id", $event->entity->form_id)
      ->where("formeable_type", 'Modules\Requestable\Entities\Category')->first();
    if (isset($formeableData->id)) {
      $values['category_id'] = $formeableData->formeable_id;
      app('Modules\Requestable\Services\RequestableService')->create($values);
    }
  }
}




