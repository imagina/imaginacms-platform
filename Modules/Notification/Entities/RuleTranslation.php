<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;

class RuleTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'notification__rule_translations';
}
