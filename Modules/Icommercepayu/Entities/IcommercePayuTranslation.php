<?php

namespace Modules\Icommercepayu\Entities;

use Illuminate\Database\Eloquent\Model;

class IcommercePayuTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    protected $table = 'icommercepayu__icommercepayu_translations';
}
