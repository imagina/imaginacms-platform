<?php

namespace Modules\Ibuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class BlockTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['internal_title'];

    protected $table = 'ibuilder__block_translations';
}
