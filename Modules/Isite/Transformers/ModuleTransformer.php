<?php

namespace Modules\Isite\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class ModuleTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     *
     * @return array
     */
    public function modelAttributes($request)
    {
        return [];
    }
}
