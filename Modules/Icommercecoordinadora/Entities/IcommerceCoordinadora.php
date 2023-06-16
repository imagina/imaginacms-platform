<?php

namespace Modules\Icommercecoordinadora\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class IcommerceCoordinadora extends Model
{
    use Translatable;

    protected $table = 'icommercecoordinadora__icommercecoordinadoras';

    public $translatedAttributes = [];

    protected $fillable = [];
}
