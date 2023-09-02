<?php

namespace Modules\Iplan\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class PlanTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     */
    public function modelAttributes($request)
    {
        $data['typeName'] = $this->typeName;

        if (is_module_enabled('Icommerce')) {
            $productTransformer = 'Modules\\Icommerce\\Transformers\\ProductTransformer';
            $data['productId'] = $this->product ? (string) $this->product->id : '';
            $data['product'] = new $productTransformer($this->whenLoaded('product'));
        }

        $data['priceFormat'] = formatMoney($this->price, true);
        $data['frequency'] = $this->frequency_label;

        return $data;
    }
}
