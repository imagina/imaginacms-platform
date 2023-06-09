<?php

namespace Modules\Iauctions\Jobs;

// CHECK THIS
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Iauctions\Entities\Auction;
use Modules\Iauctions\Events\AuctionRemainingDay;

class CheckDaysToStartAuction implements ShouldQueue
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
        $nowDate = date('Y-m-d');
        \Log::info('Iauctions: Jobs|CheckDaysToStartAuction');

        $result = Auction::select(
            \DB::raw("DATEDIFF(start_at, '$nowDate') as days_remaining"),
            'id',
            'status'
        )->where('status', 0) // INACTIVE
        ->whereRaw(\DB::raw("DATEDIFF(start_at, '$nowDate') = 1"))
        ->get();

        if (count($result) > 0) {
            foreach ($result as $item) {
                $auction = Auction::find($item->id);
                event(new AuctionRemainingDay($auction));

                \Log::info("Iauctions: Jobs|CheckDaysToStartAuction|Auction: ID $auction->id");
            }
        }
    }
}
