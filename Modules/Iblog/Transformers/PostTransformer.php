<?php

namespace Modules\Iblog\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\User\Transformers\UserProfileTransformer;

class PostTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        return [
            'statusName' => $this->when($this->status, $this->present()->status),
            'url' => $this->url ?? '#',
            'mainImage' => $this->main_image,
            'secondaryImage' => $this->when($this->secondary_image, $this->secondary_image),
            'gallery' => $this->gallery,
            'editor' => new UserProfileTransformer($this->whenLoaded('user')),
      'layoutId' => $this->layoutId,
        ];
    }
}
