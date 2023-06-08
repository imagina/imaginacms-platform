<?php

namespace Modules\Iad\Entities;

use Illuminate\Database\Eloquent\Model;

class AdTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'slug'];
    protected $table = 'iad__ad_translations';
}
