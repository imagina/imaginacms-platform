<?php

namespace Modules\Ibooking\Console;

use Illuminate\Console\Command;
use Modules\Ibooking\Entities\Reservation;

class CheckStatusReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ibooking:check-reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Log::info("Ibooking: Jobs|CheckStatusReservation");

        $nowDateComplete = date('Y-m-d H:i:s');
        $nowDate = date('Y-m-d');

        $waitingTime = setting('ibooking::waitingTimeToCancelReservation', null, 10);

        //Fix times to query search
        $timeStart = '00:'.$waitingTime.':00';
        $timeEnd = '00:'.($waitingTime + 2).':00'; //Limit 2min

        $results = Reservation::select(
            \DB::raw("TIMEDIFF('$nowDateComplete',created_at) as time_passed"),
            'id', 'status', 'created_at')
        ->where('status', 0) // Pending
        ->whereDate('created_at', $nowDate)// Reservations Today
        ->whereRaw(\DB::raw("TIMEDIFF('$nowDateComplete',created_at) >= '$timeStart'"))
        ->whereRaw(\DB::raw("TIMEDIFF('$nowDateComplete',created_at) <= '$timeEnd'"))
        ->get();

        \Log::info('results '.json_encode($results));

        if (count($results) > 0) {
            foreach ($results as $item) {
                $reservation = Reservation::find($item->id);
                $reservation->status = 2; // Canceled
                $reservation->save();
            }
        }
    }
}
