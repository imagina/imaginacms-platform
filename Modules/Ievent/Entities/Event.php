<?php

namespace Modules\Ievent\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Iplaces\Entities\Place;
use Modules\Iplaces\Entities\Route;
use Modules\Iprofile\Entities\Department;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Media\Entities\File;
use Modules\User\Entities\Sentinel\User;
use Modules\Ievent\Transformers\ServiceCategoryTransformer;

class Event extends Model
{
  use MediaRelation;

  protected $table = 'ievent__events';
  protected $fillable = [
    "title",
    "slug",
    "status",
    "date",
    "hour",
    "is_public",
    "description",
    "category_id",
    "place_id",
    "user_id",
    "department_id",
    "options"
  ];

  protected $fakeColumns = ['options'];

  protected $casts = [
    'options' => 'array'
  ];
  protected $width = [
    'team'
  ];

  public function user()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function attendants()
  {
    return $this->hasMany(Attendant::class);
  }

  public function place()
  {
    return $this->belongsTo(Place::class)->with(['city', 'category']);
  }

  public function department()
  {
    return $this->belongsTo(Department::class);
  }

  public function getAttendantsCountAttribute()
  {
    return $this->attendants->count();
  }

  public function getLastAttendantsAttribute()
  {
    return $this->attendants()->orderBy("id", "desc")->take(3)->get();
  }

  public function getStatusNameAttribute()
  {
    return (new Status())->get($this->status);
  }

  public function getOptionsAttribute($value)
  {
    $options = json_decode($value);

    if (isset($options->mainImage))
      $options->mainImage = url($options->mainImage);
    if (isset($options->secondaryImage))
      $options->secondaryImage = url($options->secondaryImage);

    return $options;
  }

  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }

  public function setUpdatedAtAttribute($value)
  {
    $this->attributes['updated_at'] = $value;
    if (isset($this->id))
      $this->save();
  }
}
