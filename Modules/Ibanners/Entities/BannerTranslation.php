<?php

namespace Modules\Ibanners\Entities;

use Illuminate\Database\Eloquent\Model;

class BannerTranslation extends Model
{
    public $fillable = [
        'title',
        'code_ads',
        'uri',
        'url',
        'active',
        'custom_html',
    ];

    protected $table = 'ibanners__banner_translations';
}
