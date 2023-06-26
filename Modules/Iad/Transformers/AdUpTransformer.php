<?php

namespace Modules\Iad\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class AdUpTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request): array
    {
        return [
            'rangeMinutes' => $this->range_minutes,
            'nextUpload' => $this->next_upload,
        ];
    }
}
