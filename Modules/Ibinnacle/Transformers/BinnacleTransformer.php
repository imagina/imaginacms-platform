<?php

namespace Modules\Ibinnacle\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class BinnacleTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        return [];
    }
}
