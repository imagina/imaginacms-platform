<?php

namespace Modules\Icomments\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Iprofile\Transformers\UserTransformer;

class CommentTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     *
     * @return array
     */
    public function modelAttributes($request)
    {
        return [
            'userProfile' => new UserTransformer($this->whenLoaded('userProfile')),
        ];
    }
}
