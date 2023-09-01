<?php

namespace Modules\Isite\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use Translatable;

    protected $table = 'isite__recommendations';

    public $translatedAttributes = [
        'title',
        'description',
    ];

    protected $fillable = [
        'name',
        'icon',
    ];
}
