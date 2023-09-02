<?php

namespace Modules\Rateable\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class RatingTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        return [];
    }
}
