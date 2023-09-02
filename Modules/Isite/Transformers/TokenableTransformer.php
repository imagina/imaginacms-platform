<?php

namespace Modules\Isite\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class TokenableTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        return [];
    }
}
