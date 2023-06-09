<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    protected $table = 'iprofile__user_department';

    protected $fillable = [
        'user_id',
        'department_id',
    ];
}
