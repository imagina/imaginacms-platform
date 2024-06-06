<?php

namespace Modules\Notification\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    
    protected $table = 'notification__notification_types';
    
    protected $fillable = [
      'title',
      'system_name'
    ];
}
