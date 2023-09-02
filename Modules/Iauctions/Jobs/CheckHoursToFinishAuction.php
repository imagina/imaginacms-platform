<?php

namespace Modules\Iauctions\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Iauctions\Entities\Auction;
use Modules\Iauctions\Events\AuctionRemainingHour;

class CheckHoursToFinishAuction implements ShouldQueue
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
     */
    public function handle()
    {
        \Log::info('Iauctions: Jobs|CheckHoursToFinishAuction');

        $nowDateComplete = date('Y-m-d H:i:s');
        //\Log::info("Iauctions: Jobs|CheckHoursToFinishAuction|nowDateComplete ".$nowDateComplete);
        $nowDate = date('Y-m-d');

        $results = Auction::select(
            \DB::raw("TIMEDIFF(end_at, '$nowDateComplete') as time_remaining"),
            'id', 'status', 'start_at', 'end_at')
        ->where('status', 1) //Active
        ->whereDate('start_at', '<=', $nowDate) // Between Dates
        ->whereDate('end_at', '>=', $nowDate) // Between Dates
        ->whereRaw(\DB::raw("TIMEDIFF(end_at, '$nowDateComplete') <= '00:59:00'"))
        ->whereRaw(\DB::raw("TIMEDIFF(end_at, '$nowDateComplete') >= '00:58:00'"))
        ->get();

        if (count($results) > 0) {
            foreach ($results as $item) {
                $auction = Auction::find($item->id);
                event(new AuctionRemainingHour($auction));

                \Log::info("Iauctions: Jobs|CheckHoursToFinishAuction|Auction: ID:$auction->id");
            }
        }
    }
}
