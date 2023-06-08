<?php

namespace Modules\Ibooking\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
  public $timestamps = false;
  protected $fillable = ['title', 'description', 'slug'];
  protected $table = 'ibooking__category_translations';
}
