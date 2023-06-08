<?php

namespace Modules\Ichat\Presenters;

use Laracasts\Presenter\Presenter;
use Illuminate\Support\Facades\Auth;
use Modules\Ichat\Entities\Message;

class ConversationPresenter extends Presenter
{

  public function lastMessageReaded()
  {
    $conversationUsers = $this->conversationUsers;
    if ($conversationUsers->count()) {
      $user = $conversationUsers->where('user_id', Auth::id())->first();
      return $user->last_message_readed;
    }
    return null;
  }

  public function lastMessage()
  {
     $message = $this->messages->sortBy('created_at',SORT_REGULAR,true)->first();
     return $message;
  }

  //Validate if has unread messages
  public function unReadMessages()
  {
    //Get last message from conversation
    $lastMessage = Message::orderBy('id', 'desc')->where('conversation_id', $this->id)->first();
    $lastMRead = $this->lastMessageReaded() ?? 0;
    $lastMId = $lastMessage->id ?? 0;
    //Response
    return ($lastMRead < $lastMId) ? true : false;
  }

}
