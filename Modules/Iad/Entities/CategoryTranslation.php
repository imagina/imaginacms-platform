<?php

namespace Modules\Iad\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'description', 'slug'];

    protected $table = 'iad__category_translations';
}
