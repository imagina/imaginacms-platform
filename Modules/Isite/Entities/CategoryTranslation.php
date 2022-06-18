<?php

namespace Modules\Isite\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class CategoryTranslation extends Model
{
  use Sluggable;
  
  public $timestamps = false;
  protected $fillable = [
    'title',
    'description',
    'slug',
    'meta_title',
    'meta_description',
    'meta_keywords'
  ];
  
  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable()
  {
    return [
      'slug' => [
        'source' => 'title'
      ]
    ];
  }
  
  protected $table = 'isite__category_translations';
}
