<?php

namespace Modules\Icommercepricelist\Entities;

use Illuminate\Database\Eloquent\Model;

class PriceListTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    protected $table = 'icommercepricelist__price_list_translations';
}
