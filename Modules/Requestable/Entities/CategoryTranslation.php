<?php

namespace Modules\Requestable\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'title'
    ];
    protected $table = 'requestable__category_translations';
}
