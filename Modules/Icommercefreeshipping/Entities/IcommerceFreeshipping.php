<?php

namespace Modules\Icommercefreeshipping\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class IcommerceFreeshipping extends Model
{
    use Translatable;

    protected $table = 'icommercefreeshipping__icommercefreeshippings';
    public $translatedAttributes = [];
    protected $fillable = [];
}
