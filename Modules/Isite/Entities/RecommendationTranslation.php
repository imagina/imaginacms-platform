<?php

namespace Modules\Isite\Entities;

use Illuminate\Database\Eloquent\Model;

class RecommendationTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $table = 'isite__recommendation_translations';
}
