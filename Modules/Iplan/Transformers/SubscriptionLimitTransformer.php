<?php

namespace Modules\Iplan\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class SubscriptionLimitTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        return [];
    }
}
