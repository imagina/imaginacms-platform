<?php

namespace Modules\Ifollow\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class FollowerTransformer extends CrudResource
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
