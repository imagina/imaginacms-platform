<?php

namespace Modules\Ibooking\Entities;

use Illuminate\Database\Eloquent\Model;

class ResourceTranslation extends Model
{
  public $timestamps = false;
  protected $fillable = ['title', 'description', 'slug'];
  protected $table = 'ibooking__resource_translations';
}
