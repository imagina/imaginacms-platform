<?php

namespace Modules\Icommercepricelist\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\Product;

class ProductList extends Model
{

    protected $table = 'icommercepricelist__product_lists';

    protected $fillable = [
        'product_id',
        'price_list_id',
        'price'
    ];

    public function product(){
        $this->belongsTo(Product::class);
    }

    public function priceList(){
        $this->belongsTo(PriceList::class);
    }

}
