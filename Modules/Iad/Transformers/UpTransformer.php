<?php

namespace Modules\Iad\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class UpTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        $data = [];
        if (is_module_enabled('Icommerce')) {
            $productTransformer = 'Modules\\Icommerce\\Transformers\\ProductTransformer';
            $data['productId'] = $this->product->id ?? '';
            $data['product'] = new $productTransformer($this->when($this->product->id, $this->product));
        }

        return $data;
    }
}
