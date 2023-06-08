<?php

namespace Modules\Isite\Entities;

use Illuminate\Database\Eloquent\Model;

class ModuleTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      "name"
    ];
    protected $table = 'isite__module_translations';
}
