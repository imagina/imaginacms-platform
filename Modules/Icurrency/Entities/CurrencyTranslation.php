<?php

namespace Modules\Icurrency\Entities;

use Illuminate\Database\Eloquent\Model;

class CurrencyTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
      'name'
    ];

    protected $table = 'icurrency__currency_translations';
}
