<?php

namespace Modules\Isite\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class RevisionTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request): array
    {
        return [];
    }
}
