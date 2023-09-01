<?php

namespace Modules\Ipoint\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class PointTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request): array
    {
        return [];
    }
}
