<?php namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Model;

class SlideTranslation extends Model
{
    public $fillable = [
        'title',
        'caption',
        'uri',
        'url',
        'active',
        'custom_html',
        'summary',
    ];

    protected $table = 'slider__slide_translations';
}
