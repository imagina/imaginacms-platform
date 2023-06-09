<?php

namespace Modules\Iad\Entities;

use Illuminate\Database\Eloquent\Model;

class UpTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $table = 'iad__ups_translations';
}
