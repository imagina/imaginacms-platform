<?php

namespace Modules\Iad\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\Ilocations\Transformers\CountryTransformer;
use Modules\Ilocations\Transformers\ProvinceTransformer;
use Modules\Ilocations\Transformers\CityTransformer;
use Modules\Iad\Transformers\CategoryTransformer;
use Modules\Iad\Transformers\FieldTransformer;
use Modules\Iad\Transformers\ScheduleTransformer;

class UpTransformer extends CrudResource
{
  /**
   * Method to merge values with response
   *
   * @return array
   */
  public function modelAttributes($request)
  {
    $data = [];
    if(is_module_enabled('Icommerce')){
      $productTransformer = 'Modules\\Icommerce\\Transformers\\ProductTransformer';
      $data['productId'] = $this->product->id ?? '';
      $data['product'] = new $productTransformer($this->when($this->product->id,$this->product));
    }
    return $data;
  }

}
