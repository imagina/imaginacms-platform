<?php

namespace Modules\Icommercepricelist\Events\Handlers;

//Support
use Modules\Icommercepricelist\Entities\ProductList;

class RefreshProductPriceLists
{
    public function __construct()
    {
    }

    public function handle($event)
    {
        $product = $event->entity;
        foreach ($product->priceLists as $priceList) {
            if ($priceList->criteria == 'percentage') {
                $value = ($product->price * $priceList->value) / 100; //Example value pricelist = 5 (Calculate 5%)
                $price = $product->price;
                if ($priceList->operation_prefix == '-') {
                    $price -= $value;
                } else {
                    $price += $value;
                }
                ProductList::where('id', $priceList->pivot->id)->update([
                    'price' => $price,
                ]);
            }
        }
    }//  handle
}
