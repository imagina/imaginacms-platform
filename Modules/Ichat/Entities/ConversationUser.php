<?php

namespace Modules\Ichat\Entities;

use Illuminate\Database\Eloquent\Model;

class ConversationUser extends Model
{
    protected $table = 'ichat__conversation_user';

    protected $fillable = [
        'conversation_id',
        'user_id',
        'last_message_readed',
        'unread_messages_count',
    ];

    public function conversation()
    {
        return $this->belongsTo('Modules\Ichat\Entities\Conversation', 'conversation_id');
    }

    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'user_id');
    }
}
