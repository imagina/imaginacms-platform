<?php

namespace Modules\Ievent\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Media\Entities\File;

class Category extends Model
{
  use Translatable, MediaRelation, AuditTrait;

  protected $table = 'ievent__categories';
  public $translatedAttributes = [
    'title',
    'description',
    'slug'
  ];
  protected $fillable = [
    'parent_id',
    'place_category_id',
    'status',
    'options'
  ];

  public function parent()
  {
    return $this->belongsTo('Modules\Ievent\Entities\Category', 'parent_id');
  }

  public function placeCategory()
  {
    return $this->belongsTo(\Modules\Iplaces\Entities\Category::class, 'place_category_id');
  }

  public function children()
  {
    return $this->hasMany('Modules\Ievent\Entities\Category', 'parent_id');
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
}
