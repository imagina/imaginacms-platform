<?php

namespace Modules\Iplan\Entities;

use Illuminate\Database\Eloquent\Model;

class PlanTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $table = 'iplan__plan_translations';
}
