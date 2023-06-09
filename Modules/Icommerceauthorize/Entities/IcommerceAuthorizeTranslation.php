<?php

namespace Modules\Icommerceauthorize\Entities;

use Illuminate\Database\Eloquent\Model;

class IcommerceAuthorizeTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    protected $table = 'icommerceauthorize__icommerceauthorize_translations';
}
