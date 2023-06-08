<?php

namespace Modules\Ibinnacle\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Binnacle extends CrudModel
{
  use Translatable;

  protected $table = 'ibinnacle__binnacles';
  public $transformer = 'Modules\Ibinnacle\Transformers\BinnacleTransformer';
  public $repository = 'Modules\Ibinnacle\Repositories\BinnacleRepository';
  public $requestValidation = [
    'create' => 'Modules\Ibinnacle\Http\Requests\CreateBinnacleRequest',
    'update' => 'Modules\Ibinnacle\Http\Requests\UpdateBinnacleRequest',
  ];
  public $translatedAttributes = [];
  protected $fillable = [
    'description',
    'binnacle_id',
    'binnacle_type',
  ];
}
