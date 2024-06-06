<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;

class ProviderTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      "description"
    ];
    protected $table = 'notification__provider_translations';
}
