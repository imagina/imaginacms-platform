<?php

namespace Modules\Icommercebraintree\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class IcommerceBraintree extends Model
{
    use Translatable;

    protected $table = 'icommercebraintree__icommercebraintrees';

    public $translatedAttributes = [];

    protected $fillable = [];
}
