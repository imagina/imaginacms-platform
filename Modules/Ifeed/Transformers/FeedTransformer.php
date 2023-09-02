<?php

namespace Modules\Ifeed\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class FeedTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        return [];
    }
}
