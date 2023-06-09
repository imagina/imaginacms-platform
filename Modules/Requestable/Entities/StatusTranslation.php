<?php

namespace Modules\Requestable\Entities;

use Illuminate\Database\Eloquent\Model;

class StatusTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
    ];

    protected $table = 'requestable__status_translations';
}
