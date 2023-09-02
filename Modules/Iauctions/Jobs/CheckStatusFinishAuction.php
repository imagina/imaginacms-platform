<?php

namespace Modules\Iauctions\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Iauctions\Entities\Auction;
use Modules\Iauctions\Events\AuctionWasFinished;

class CheckStatusFinishAuction implements ShouldQueue
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
        \Log::info('Iauctions: Jobs|CheckStatusFinishAuction');

        $nowDate = date('Y-m-d');
        $nowHour = date('H:i:00');

        $results = Auction::select('id', 'status', 'end_at')
        ->where('status', 1) //Active
        ->whereDate('end_at', $nowDate) // Only Auctions to Finish Today
        ->whereTime('end_at', '<=', $nowHour) // Hour
        ->get();

        if (count($results) > 0) {
            foreach ($results as $item) {
                $auction = Auction::find($item->id);
                $auction->status = 2; // Finished
                $auction->save();
                event(new AuctionWasFinished($auction));

                \Log::info("Iauctions: Jobs|CheckStatusFinishAuction|Updated Status AuctionID: $auction->id");

                // Set Winner for this Auction
                $result = app('Modules\Iauctions\Services\AuctionService')->setWinner($auction);
            }
        }
    }
}
