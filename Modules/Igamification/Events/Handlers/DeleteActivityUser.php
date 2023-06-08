<?php

namespace Modules\Igamification\Events\Handlers;

use Modules\Igamification\Repositories\ActivityRepository;
use Modules\Igamification\Events\ActivityWasCompleted;

class DeleteActivityUser
{

    public $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
      $this->activityRepository = $activityRepository; 
    }

    public function handle($event)
    {

        \Log::info('Igamification: Events|Handlers|DeleteActivityUser');
        
        // All params Event
        $params = $event->params;
        // Extra data custom event entity
        $extraData = $params['extraData'];

        $systemNameActivity = $extraData['systemNameActivity'];

        // Only activity exist and is active
        $activity = $this->activityRepository->findByAttributes([
            'system_name'=> $systemNameActivity,
            'status' => 1 //Active;
        ]);

        if(!is_null($activity)){

            //Get User Logged - Middleware Auth
            $userId = \Auth::user()->id;
          
            //Delete in Pivot
            $activity->users()->detach($userId);
            
        }else{
            \Log::info('Igamification: Events|Handlers|SyncActivityUser| Activity no exist or is inactive ');
        }


    }// If handle



}