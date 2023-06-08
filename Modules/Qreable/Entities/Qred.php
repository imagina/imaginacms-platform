<?php

namespace Modules\Qreable\Entities;

use Illuminate\Database\Eloquent\Model;

class Qred extends Model
{

    protected $table = 'qreable__qred';
    protected $fillable = ['qreable_type','qreable_id','zone','redirect'];
}
