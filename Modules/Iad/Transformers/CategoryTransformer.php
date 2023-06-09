<?php

namespace Modules\Iad\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class CategoryTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     *
     * @return array
     */
    public function modelAttributes($request): array
    {
        return [
            'url' => $this->when($this->url, $this->url),
        ];
    }
}
