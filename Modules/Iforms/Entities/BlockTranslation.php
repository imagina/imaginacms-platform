<?php

namespace Modules\Iforms\Entities;

use Illuminate\Database\Eloquent\Model;

class BlockTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title', 'description',
    ];

    protected $table = 'iforms__block_translations';
}
