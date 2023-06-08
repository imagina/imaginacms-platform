<?php

namespace Modules\Iad\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\Ilocations\Transformers\CountryTransformer;
use Modules\Ilocations\Transformers\ProvinceTransformer;
use Modules\Ilocations\Transformers\CityTransformer;
use Modules\Ilocations\Transformers\NeighborhoodTransformer;
use Modules\Iad\Transformers\CategoryTransformer;
use Modules\Iad\Transformers\FieldTransformer;
use Modules\Iad\Transformers\ScheduleTransformer;
use Modules\Isite\Transformers\RevisionTransformer;

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
      'defaultPrice' => $this->defaultPrice
    ];
  }
  
}
