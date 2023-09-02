<?php

namespace Modules\Media\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class ZoneTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        return [];
    }
}
