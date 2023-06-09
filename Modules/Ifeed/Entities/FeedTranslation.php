<?php

namespace Modules\Ifeed\Entities;

use Illuminate\Database\Eloquent\Model;

class FeedTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    protected $table = 'ifeed__feed_translations';
}
