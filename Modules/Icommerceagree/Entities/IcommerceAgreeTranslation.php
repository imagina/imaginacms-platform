<?php

namespace Modules\Icommerceagree\Entities;

use Illuminate\Database\Eloquent\Model;

class IcommerceAgreeTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    protected $table = 'icommerceagree__icommerceagree_translations';
}
