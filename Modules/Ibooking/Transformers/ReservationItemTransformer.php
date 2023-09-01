<?php

namespace Modules\Ibooking\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class ReservationItemTransformer extends CrudResource
{
    public function modelAttributes($request)
    {
        return [
            'statusName' => $this->statusName,
        ];
    }
}
