<?php

namespace Modules\Requestable\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryRuleTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'requestable__category_rule_translations';
    protected $fillable = [
        'title'
    ];
}
