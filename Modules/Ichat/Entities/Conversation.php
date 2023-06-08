<?php

namespace Modules\Ichat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laracasts\Presenter\PresentableTrait;
use Modules\Ichat\Presenters\ConversationPresenter;
use Modules\Core\Support\Traits\AuditTrait;

class Conversation extends Model
{
  use PresentableTrait, AuditTrait;

  //protected $presenter = ConversationPresenter::class;

  protected $table = 'ichat__conversations';

  protected $fillable = [
    'private',
    'status',
    'entity_type',
    'entity_id',
  ];

  public function entity()
  {
    return $this->belongsTo($this->entity_type,'entity_id');
  }

  public function messages()
  {
    return $this->hasMany('Modules\Ichat\Entities\Message');
  }

  public function lastMessage()
  {
    return
        $this->hasOne('Modules\Ichat\Entities\Message')->orderBy('created_at','desc');
  }

  public function users()
  {
    $entityPath = "Modules\\User\\Entities\\" . config('asgard.user.config.driver') . "\\User";
    return $this->belongsToMany($entityPath, 'ichat__conversation_user')->withTimestamps();
  }

  public function conversationUsers()
  {
    return $this->hasMany('Modules\Ichat\Entities\ConversationUser');
  }

}
