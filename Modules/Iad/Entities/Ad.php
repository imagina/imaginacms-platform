<?php

namespace Modules\Iad\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Iad\Entities\Category;
use Modules\Iad\Entities\Field;
use Modules\Iad\Entities\Schedule;
use Modules\Ilocations\Entities\Country;
use Modules\Ilocations\Entities\Province;
use Modules\Ilocations\Entities\City;
use Modules\Ilocations\Entities\Locality;
use Modules\Ilocations\Entities\Neighborhood;
use Modules\Iad\Entities\AdStatus;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Isite\Traits\RevisionableTrait;

use Modules\Core\Support\Traits\AuditTrait;

class Ad extends CrudModel
{
  use Translatable, MediaRelation;

  public $transformer = 'Modules\Iad\Transformers\AdTransformer';
  public $entity = 'Modules\Iad\Entities\Ad';
  public $repository = 'Modules\Iad\Repositories\AdRepository';
  public $requestValidation = [
    'create' => 'Modules\Iad\Http\Requests\CreateAdRequest',
    'update' => 'Modules\Iad\Http\Requests\UpdateAdRequest',
  ];
  protected $table = 'iad__ads';

  public $translatedAttributes = ['title', 'description', 'slug'];
  protected $fillable = [
    'user_id',
    'status',
    'min_price',
    'max_price',
    'country_id',
    'province_id',
    'city_id',
    'neighborhood_id',
    'lat',
    'lng',
    'featured',
    'sort_order',
    'options',
    'uploaded_at',
    'checked',
  ];
  protected $fakeColumns = ['options'];
  protected $casts = ['options' => 'array'];

  public function user()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
  }

  public function categories()
  {
    return $this->belongsToMany(Category::class, 'iad__ad_category');
  }


  public function adUps()
  {
    return $this->hasMany(AdUp::class);
  }


  public function fields()
  {
    return $this->hasMany(Field::class);
  }

  public function schedule()
  {
    return $this->hasMany(Schedule::class);
  }

  public function country()
  {
    return $this->belongsTo(Country::class);
  }

  public function province()
  {
    return $this->belongsTo(Province::class);
  }

  public function city()
  {
    return $this->belongsTo(City::class);
  }

  public function locality()
  {
    return $this->belongsTo(Locality::class);
  }

  public function neighborhood()
  {
    return $this->belongsTo(Neighborhood::class);
  }

  public function getStatusNameAttribute()
  {
    $adStatuses = new AdStatus();
    return collect($adStatuses->get())->where('id', $this->status)->pluck('name')->first();
  }

  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }

  /**
   * URL product
   * @return string
   */
  public function getUrlAttribute()
  {

    return \URL::route(\LaravelLocalization::getCurrentLocale() . '.iad.ad.show', $this->slug);

  }

  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }

  public function getEntityTitleAttribute()
  {
    return trans('Test entity name');
  }

  public function getDefaultPriceAttribute()
  {
    //instance default price
    $defaultPrice = 0;

    //Search default price in list price
    if (isset($this->options->prices) && is_array($this->options->prices)) {
      $defaultPrice = collect($this->options->prices)->where('default', '1')->first();
    }

    //response
    return $defaultPrice ? $defaultPrice->value : $this->min_price;
  }

}
