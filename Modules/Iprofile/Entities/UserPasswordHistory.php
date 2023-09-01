<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;

class UserPasswordHistory extends Model
{
    protected $table = 'iprofile__user_password_history';

    protected $fillable = [
        'user_id',
        'password',
    ];

    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }
}
