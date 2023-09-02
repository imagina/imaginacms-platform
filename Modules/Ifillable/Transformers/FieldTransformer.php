<?php

namespace Modules\Ifillable\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class FieldTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        return [];
    }
}
