<?php

namespace Modules\Ischedulable\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class WorkTimeTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     *
     * @return array
     */
    public function modelAttributes($request): array
    {
        return [];
    }
}
