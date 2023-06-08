<?php

namespace Modules\Ichat\Events\Handlers;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Modules\Ichat\Entities\ConversationUser;
use Modules\Iprofile\Entities\Role;
use Modules\Notification\Services\Inotification;
use Modules\Ichat\Transformers\MessageTransformer;

class MessageWasSavedListener
{
  private $conversationUser;
  private $inotification;

  public function __construct(
    ConversationUser $conversationUser,
    Inotification    $inotification)
  {
    $this->conversationUser = $conversationUser;
    $this->inotification = $inotification;
  }

  /**
   * Handle the event.
   *
   * @param object $event
   * @return void
   */
  public function handle($event)
  {
    //Get message
    $message = $event->message;

    //Get users to notify message
    $usersToNotifyId = $this->getUsersToNotify($message);

    //Manage conversation users info
    $this->manageConversationUsersInfo($message, $usersToNotifyId);

    //Notify conversation users
    $this->notifyConversationUsers($message, $usersToNotifyId);
  }

  // Return the users no notify the message
  private function getUsersToNotify($message)
  {
    //Get users conversation to notify
    $usersId = $message->conversation->conversationUsers->whereNotIn('user_id', [Auth::user()->id, $message->user_id])
      ->pluck('user_id')->toArray();

    //If the message is of a public conversation search for all users with the "ichat.conversations.index-all" permission
    if (isset($message->conversation) && !$message->conversation->private) {
      $rolesWithPermission = [];
      //Get roles with the permission
      $roles = Role::where("permissions", "like", "%ichat.conversations.index-all%")->get();
      //Validate if the permission is true
      foreach ($roles as $role) {
        if (isset($role->permissions["ichat.conversations.index-all"]) && $role->permissions["ichat.conversations.index-all"]) {
          $rolesWithPermission[] = $role->id;
        }
      }
      //Get all users with the roles
      if (count($rolesWithPermission)) {
        $usersId = array_merge($usersId, \DB::table("role_users")->whereIn("role_id", $rolesWithPermission)
          ->get()->pluck("user_id")->toArray());
      }
    }

    //Response
    return array_unique($usersId);
  }

  //Manage conversation users infor
  public function manageConversationUsersInfo($message, $usersToNotifyId)
  {
    //Update last message info to user who send message
    ConversationUser::where('conversation_id', $message->conversation_id)
      ->where('user_id', $message->user_id)->update(['last_message_readed' => $message->id, 'unread_messages_count' => 0]);

    //Update last message info to conversation users
    foreach ($usersToNotifyId as $userId) {
      ConversationUser::where('conversation_id', $message->conversation_id)
        ->where('user_id', $userId)->update(['unread_messages_count' => \DB::raw('(
            SELECT COUNT(*) FROM ichat__messages
            WHERE ichat__messages.conversation_id = ichat__conversation_user.conversation_id
            AND ichat__messages.id > ichat__conversation_user.last_message_readed 
        )')]);
    }
  }

  //Notify to conversations users
  public function notifyConversationUsers($message, $usersToNotifyId)
  {
    //Send notification
    $this->inotification->to(['broadcast' => $usersToNotifyId])->push([
      "title" => "New message",
      "message" => "You have a new message!",
      "link" => url(''),
      "isAction" => true,
      "frontEvent" => [
        "name" => "inotification.chat.message",
        "data" => new MessageTransformer($message)
      ],
      "setting" => ["saveInDatabase" => 1]
    ]);
  }
}
