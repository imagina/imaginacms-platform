<?php

namespace Modules\Rateable\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

// Trait Icomments
use Modules\Icomments\Traits\Commentable;

class Rating extends CrudModel
{

  use Commentable;

  protected $table = 'rateable__ratings';
  public $transformer = 'Modules\Rateable\Transformers\RatingTransformer';
  public $repository = 'Modules\Rateable\Repositories\RatingRepository';
  public $requestValidation = [
    'create' => 'Modules\Rateable\Http\Requests\CreateRatingRequest',
    'update' => 'Modules\Rateable\Http\Requests\UpdateRatingRequest',
  ];

  protected $fillable = [
    'user_id',
    'rateable_type',
    'rateable_id',
    'rating'
  ];

  public function user()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
  }

}
