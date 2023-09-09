<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;

class RoleTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'role_translations';
    protected $fillable = [
        'title'
    ];
}
