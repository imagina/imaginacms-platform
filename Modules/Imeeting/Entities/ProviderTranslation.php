<?php

namespace Modules\Imeeting\Entities;

use Illuminate\Database\Eloquent\Model;

class ProviderTranslation extends Model
{
    public $timestamps = false;

     protected $fillable = [
      'title',
      'description',
      'provider_id',
      'locale',
    ];

    protected $table = 'imeeting__provider_translations';
}
