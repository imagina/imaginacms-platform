<?php
namespace Modules\Ievent\Events\Handlers;

use Modules\Ievent\Events\EventWasCreated;
use Modules\Ievent\Repositories\AttendantRepository;



class SaveFirstAttendant
{
    private $attendant;
    public function __construct(AttendantRepository $attendant)
    {
        $this->attendant = $attendant;
    }
    public function handle(EventWasCreated $event)
    {

        $event = $event->event;
      
        $data = [
          "event_id" => $event->id,
          "user_id" => $event->user_id
        ];
        
        $this->attendant->create($data);
    }

}