<?php

namespace Modules\Iauctions\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Iauctions\Entities\Auction;
use Modules\Iauctions\Events\AuctionWasActived;

class CheckStatusInitAuction implements ShouldQueue
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
    public function handle(): void
    {
        \Log::info('Iauctions: Jobs|CheckStatusInitAuction');

        $nowDate = date('Y-m-d');
        $nowHour = date('H:i:00');
        //\Log::info("Iauctions: Jobs|CheckStatusInitAuction|hour ".$nowHour);

        $results = Auction::select('id', 'status', 'start_at', 'end_at')
        ->where('status', 0) //Inactive
        ->whereDate('start_at', $nowDate) // Only Auctions Today
        ->whereTime('start_at', '<=', $nowHour) // Hour
        ->get();

        if (count($results) > 0) {
            foreach ($results as $item) {
                $auction = Auction::find($item->id);
                $auction->status = 1; // Active
                $auction->save();
                event(new AuctionWasActived($auction));

                \Log::info("Iauctions: Jobs|CheckStatusInitAuction|Updated Status AuctionID: $auction->id");
            }
        }
    }
}
