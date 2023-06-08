<?php

namespace Modules\Icurrency\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use Translatable;

    protected $table = 'icurrency__currencies';

    public $translatedAttributes = [
        'name',
    ];
    protected $fillable = [
        'code',
        'symbol_left',
        'symbol_right',
        'decimal_place',
        'value',
        'status',
        'default_currency',
        'options',
    ];

    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array'
    ];

    /* Query Scopes */
    public function scopeDefaultCurrency($query)
    {
        return $query->where('default_currency', 1)->first();
    }

    public function scopeNoDefaultCurrency($query)
    {
        return $query->where('default_currency', 0)->get();
    }

    public function scopeCurrencyCode($query, $currency)
    {
      return $query->where('code', strtoupper($currency))->first();
    }

    public function scopeActivedCurrencies($query)
    {
        return $query->where('status', 1)->get();
    }

}
