<?php

namespace Modules\Icheckin\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    protected $table = 'icheckin__jobs';

    protected $fillable = [
      'title',
      'status'
    ];
}
