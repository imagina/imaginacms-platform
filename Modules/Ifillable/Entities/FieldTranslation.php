<?php

namespace Modules\Ifillable\Entities;

use Illuminate\Database\Eloquent\Model;

class FieldTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['value'];

    protected $table = 'ifillable__field_translations';

    protected $casts = ['value' => 'array'];
}
