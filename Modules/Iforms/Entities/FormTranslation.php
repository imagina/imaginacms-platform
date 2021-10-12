<?php

namespace Modules\Iforms\Entities;

use Illuminate\Database\Eloquent\Model;

class FormTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'submit_text',
        'success_text',
    ];

    protected $table = 'iforms__form_translations';
}
