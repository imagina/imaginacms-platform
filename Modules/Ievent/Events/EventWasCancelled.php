<?php

namespace Modules\Ievent\Events;

use Illuminate\Queue\SerializesModels;

class EventWasCancelled
{
  use SerializesModels;
  
  public $entity;
  public $event;
  public $user;
  
  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($event, $user)
  {
    $this->event = $event;
    $this->entity = $event;
    $this->user = $user;

  }
  
  public function notification()
  {
    $users = $this->event->team->users;
 
    $users = $users->whereNotIn("id", [$this->user->id]);
    return [
      "title" => "Evento cancelado",
      "message" => "El equipo " . $this->event->team->title . " ha cancelado el evento \"".$this->event->title."\"",
      "icon" => "far fa-calendar-times",
      "link" => env('FRONTEND_URL') . "/?showEventId=" . $this->event->id,
      "view" => "iteam::emails.eventCancelled.eventCancelled",
      "recipients" => [
        "email" => $users->pluck('email')->toArray(),
        "broadcast" => $users->pluck('id')->toArray(),
        "push" => $users->pluck('id')->toArray(),
      ],
      "event" => $this->entity
    ];
  }
}
