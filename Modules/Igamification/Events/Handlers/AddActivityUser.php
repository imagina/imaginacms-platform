<?php

namespace Modules\Igamification\Events\Handlers;

use Modules\Igamification\Repositories\ActivityRepository;
use Modules\Igamification\Events\ActivityWasCompleted;

class AddActivityUser
{

    public $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
      $this->activityRepository = $activityRepository; 
    }

    public function handle($event)
    {

        \Log::info('Igamification: Events|Handlers|AddActivityUser');
        
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
          
            //Sync in Pivot
            $activity->users()->syncWithoutDetaching([$userId]);
            
        }else{
            \Log::info('Igamification: Events|Handlers|SyncActivityUser| Activity no exist or is inactive ');

            //throw new \Exception('Igamification: Events|Handlers|SaveActivityUser| Activity no exist or is inactive ', 500);
        }


    }// If handle



}