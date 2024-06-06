<?php

namespace Modules\Iforms\Entities;

use Illuminate\Database\Eloquent\Model;

class FormTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
      'title'
    ];

    protected $table = 'iforms__form_translations';
}
