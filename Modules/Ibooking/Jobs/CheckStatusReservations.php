<?php

namespace Modules\Ibooking\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Ibooking\Entities\Reservation;

class CheckStatusReservations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        \Log::info("Ibooking: Jobs|CheckStatusReservation");

        $nowDateComplete = date('Y-m-d H:i:s');
        $nowDate = date('Y-m-d');
        
        $waitingTime = setting('ibooking::waitingTimeToCancelReservation',null, 10);

        //Fix times to query search
        $timeStart = '00:'.$waitingTime.':00';
        $timeEnd = '00:'.($waitingTime+2).':00'; //Limit 2min
        
        $results = Reservation::select(
            \DB::raw("TIMEDIFF('$nowDateComplete',created_at) as time_passed"),
            "id","status","created_at")
        ->where("status", 0) // Pending
        ->whereDate("created_at", $nowDate)// Reservations Today
        ->whereRaw(\DB::raw("TIMEDIFF('$nowDateComplete',created_at) >= '$timeStart'"))
        ->whereRaw(\DB::raw("TIMEDIFF('$nowDateComplete',created_at) <= '$timeEnd'")) 
        ->get();

        //\Log::info("results ".json_encode($results));

        if(count($results) > 0) {
            foreach ($results as $item) {
                $reservation = Reservation::find($item->id);
                $reservation->status = 2; // Canceled
                $reservation->save();
            }
        }

    }
}
