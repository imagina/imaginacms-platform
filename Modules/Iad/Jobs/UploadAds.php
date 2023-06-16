<?php

namespace Modules\Iad\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Iad\Entities\Ad;
use Modules\Iad\Entities\AdUp;

class UploadAds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public function handle()
    {
        $nowDate = date('Y-m-d');
        $nowHour = date('H:i:00');
        \Log::info("Running Ad Uploads | Now Date: $nowDate | Now Hour: $nowHour");

        $result = AdUp::select(
            \DB::raw("DATEDIFF('$nowDate', from_date) as days_elapsed"),
            \DB::raw('iad__ad_up.*')
        )
          ->where('status', 1)
          ->where('from_date', '<=', "$nowDate")
          ->where('to_date', '>=', "$nowDate")
          ->where('from_hour', '<=', "$nowHour")
          ->where('to_hour', '>=', "$nowHour")
          ->whereRaw(\DB::raw('ups_counter/ups_daily <= days_limit'))
          ->whereRaw(\DB::raw("DATEDIFF('$nowDate', from_date) = TRUNCATE(ups_counter/ups_daily,0)"))
          ->get();

        $everyUp = config('asgard.iad.config.everyUp');

        $upsToUpload = [];
        foreach ($result as $item) {
            //validate for each item if the range time is valid to upload
            $start = strtotime($item->from_hour);
            $end = strtotime(date('H:i:s'));

            $nowRange = ($end - $start) / 60 / $everyUp;

            if ($nowRange >= (($item->ups_counter - ($item->days_counter * $item->ups_daily)) * $item->range_minutes)) {
                $item->ups_counter++;
                \Log::info("AD ID: $item->ad_id uploaded | Ups Counter: ".($item->ups_counter).' | Days Counter: '.
                  ($item->ups_counter % $item->ups_daily == 0 ? $item->days_counter + 1 : $item->days_counter).
                  (($item->next_upload ? ' | Next Upload: '.$item->next_upload : '')).
                  ' | Range minutes: '.$item->range_minutes.' | NOW Range: '.$nowRange.
                  ' | Cumulative time.:'.(($item->ups_counter - ($item->days_counter * $item->ups_daily)) * $item->range_minutes));
                array_push($upsToUpload, $item);
            } else {
                \Log::info("AD ID: $item->ad_id (NOT uploaded) | Ups Counter: ".($item->ups_counter).' | Days Counter: '.
                  ($item->ups_counter % $item->ups_daily == 0 ? $item->days_counter : $item->days_counter).
                  (($item->next_upload ? ' | Next Upload: '.$item->next_upload : '')).
                  ' | Range minutes: '.$item->range_minutes.' | NOW Range: '.$nowRange.
                  ' | Cumulative time.:'.(($item->ups_counter - ($item->days_counter * $item->ups_daily)) * $item->range_minutes));
            }
        }

        $upsToUpload = collect($upsToUpload);
        if ($upsToUpload->isNotEmpty()) {
            //uploading ads
            Ad::whereIn('id', $upsToUpload->pluck('ad_id')->toArray())
              ->update(['uploaded_at' => \DB::raw('NOW()')]);

            //updating ups_counter
            AdUp::whereIn('id', $upsToUpload->pluck('id')->toArray())
              ->update(
                  [
                      'ups_counter' => \DB::raw('ups_counter+1'),
                      'days_counter' => \DB::raw('CASE WHEN ups_counter%ups_daily = 0 THEN days_counter+1 ELSE days_counter END'),
                  ]);
        } else {
            \Log::info('Nothing to Upload');
        }

        $upsToDisabled = $result->filter(function ($item, $key) {
            $realDaysElapsed = (int) (($item->ups_counter + 1) / $item->ups_daily);

            return $realDaysElapsed != $item->days_elapsed && $realDaysElapsed >= $item->days_limit;
        });

        if ($upsToDisabled->isNotEmpty()) {
            //disabling ad-ups
            AdUp::whereIn('id', $upsToDisabled->pluck('id')->toArray())
              ->update(['status' => 0]);
        }
    }
}
