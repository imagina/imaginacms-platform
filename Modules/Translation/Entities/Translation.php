<?php

namespace Modules\Translation\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Translation extends Model
{
    use Translatable,BelongsToTenant;

    protected $table = 'translation__translations';
    public $translatedAttributes = ['value'];
    protected $fillable = ['key', 'value'];
}
