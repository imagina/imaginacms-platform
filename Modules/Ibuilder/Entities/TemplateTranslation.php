<?php

namespace Modules\Ibuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class TemplateTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'ibuilder__template_translations';
}
