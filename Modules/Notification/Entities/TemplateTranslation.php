<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;

class TemplateTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'name'
    ];
    protected $table = 'notification__template_translations';
}
