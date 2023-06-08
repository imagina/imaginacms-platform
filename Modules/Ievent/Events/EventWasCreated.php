<?php
/**
 * Created by PhpStorm.
 * User: imagina
 * Date: 3/10/2018
 * Time: 5:41 PM
 */

namespace Modules\Ievent\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class EventWasCreated
{
  
  
    public $event;
    public $entity;

    /**
     * Create a new event instance.
     *
     * @param $entity
     * @param array $data
     */
    public function __construct($event)
    {

        $this->event = $event;
        $this->entity = $event;
    }
  
  public function notification(){
    $users = $this->event->team->users;
    $eventCreator = $this->event->user;
  
    $users = $users->whereNotIn("id",[$eventCreator->id]);
    return [
      "title" =>  "Nuevo evento",
      "message" =>  "El equipo ".$this->event->team->title. " ha creado un evento",
      "icon" => "icon-calendar",
      "link" => env('FRONTEND_URL')."/?showEventId=".$this->event->id,
      "view" => "iteam::emails.eventCreated.eventCreated",
      "recipients" => [
        "email" => $users->pluck('email')->toArray(),
        "broadcast" => $users->pluck('id')->toArray(),
        "push" => $users->pluck('id')->toArray(),
      ],
      "event" => $this->entity
    ];
  }

}