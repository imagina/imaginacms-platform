<?php

namespace Modules\Igamification\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class CategoryTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        $user = \Auth::user();

        return [
            'userCompleted' => $user && $this->users->where('id', $user->id)->first(),
        ];
    }
}
