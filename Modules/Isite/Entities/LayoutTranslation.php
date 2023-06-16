<?php

namespace Modules\Isite\Entities;

use Illuminate\Database\Eloquent\Model;

class LayoutTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
    ];

    protected $table = 'isite__layout_translations';
}
