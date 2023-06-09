<?php

namespace Modules\Icommercexpay\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class IcommerceXpay extends Model
{
    use Translatable;

    protected $table = 'icommercexpay__icommercexpays';

    public $translatedAttributes = [];

    protected $fillable = [];
}
