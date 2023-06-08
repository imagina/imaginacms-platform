<?php

namespace Modules\Iappointment\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'status'
    ];
    protected $table = 'iappointment__category_translations';
}
