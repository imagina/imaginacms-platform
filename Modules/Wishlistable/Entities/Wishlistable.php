<?php

namespace Modules\Wishlistable\Entities;

use Illuminate\Database\Eloquent\Model;

class Wishlistable extends Model
{
    protected $table = 'wishlistable__wishlistables';

    protected $fillable = [
        'user_id',
        'wishlistable_type',
        'wishlistable_id',
    ];
}
