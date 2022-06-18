<?php


namespace Modules\Isite\Traits;

use Modules\Icommerce\Entities\Product;

/**
* Trait to create a product with data from an Entity
* Used in : Ibooking
*/
trait WithProduct
{

    /**
    * Boot trait method
    */
    public static function bootWithProduct()
    {

        // Validate Only Icommerce Enabled
        if(is_module_enabled('Icommerce')){
            //Listen event after create model
            static::createdWithBindings(function ($model) {
              $model->syncProduct();
            });

            static::updatedWithBindings(function ($model) {
              $model->syncProduct();
            });
        }

    }


    /**
    * Sync Product
    */
    public function syncProduct(){


        $product = \Modules\Icommerce\Entities\Product::updateOrCreate([
            'entity_type' => get_class($this),
            'entity_id' => $this->id
        ],[
            'name' => $this->title ?? $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'summary' => $this->summary ?? substr($this->description, 0, 150),
            'price' => $this->price ?? 0,
            'status' => $this->status ?? 1, //ENABLED
            'stock_status' => $this->stock_status ?? 1, //INSTOCK
            'quantity' => $this->quantity ?? 999999,
            'shipping' => $this->requiredShipping ?? 1
        ]);

    }


    /**
     * Make the Productable morph relation
     * @return object
     */
    public function products()
    {
      
        return $this->morphMany("Modules\Icommerce\Entities\Product", 'entity');
    }

    public function getProductAttribute(){
     return Product::query()->where('entity_type', get_class($this))
      ->where('entity_id', $this->id)->withoutTenancy()->first();
    }

}
