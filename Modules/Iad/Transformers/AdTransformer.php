<?php

namespace Modules\Iad\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class AdTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     *
     * @return array
     */
    public function modelAttributes($request)
    {
        return [
            'statusName' => $this->when(isset($this->statusName), $this->statusName),
            'checked' => $this->checked ? '1' : '0',
            'sortOrder' => $this->sort_order ?? 0,
            'defaultPrice' => $this->defaultPrice,
        ];
    }
}
