<?php

namespace Modules\Igamification\Entities;

use Illuminate\Database\Eloquent\Model;

class ActivityTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $table = 'igamification__activity_translations';
}
