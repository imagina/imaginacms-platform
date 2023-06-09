<?php

namespace Modules\Iad\Entities;

use Illuminate\Database\Eloquent\Model;

class UpLog extends Model
{
    protected $table = 'iad__up_log';

    protected $fillable = [
        'ad_up_id',

    ];
}
