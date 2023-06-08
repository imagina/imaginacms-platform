<?php

namespace Modules\Iplaces\Entities;

use Illuminate\Database\Eloquent\Model;

class ZoneTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','description'];
    protected $table = 'iplaces__zone_translations';
}
