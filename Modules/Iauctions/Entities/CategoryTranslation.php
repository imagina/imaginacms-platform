<?php

namespace Modules\Iauctions\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
    ];

    protected $table = 'iauctions__category_translations';
}
