<?php

namespace Modules\Icommercecredibanco\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class IcommerceCredibanco extends Model
{
    use Translatable;

    protected $table = 'icommercecredibanco__icommercecredibancos';

    public $translatedAttributes = [];

    protected $fillable = [];
}
