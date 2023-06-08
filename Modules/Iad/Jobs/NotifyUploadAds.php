<?php

namespace Modules\Iad\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Iad\Entities\Ad;
use Modules\Iad\Entities\AdUp;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Iad\Entities\Up;

class NotifyUploadAds implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, SerializesModels;

  public $notification;
  public $user;

  public function __construct()
  {
    $this->notification = app("Modules\Notification\Services\Inotification");
    $this->user = app("Modules\Iprofile\Repositories\UserApiRepository");
  }

  public function handle()
  {
    $nowDate = date('Y-m-d');
    $nowHour = date('H:i:00');

    $result = AdUp::select(
      \DB::raw("DATEDIFF(to_date, '$nowDate') as days_remaining"),
      "ad_id",
      "up_id",
      "id",
    )
      ->where("status", 1)
      ->whereRaw(\DB::raw("DATEDIFF(to_date, '$nowDate') <= 3"))
      ->whereRaw(\DB::raw("DATEDIFF(to_date, '$nowDate') >= -2"))
      ->get();


    if(count($result) > 0) {

       $ads = Ad::whereIn("id",$result->pluck("ad_id")->toArray())->with("translations")->get();
       $ups = Up::whereIn("id",$result->pluck("up_id")->toArray())->with("translations")->get();

       $params = ["filter" => ["userId" => $ads->pluck("user_id")->toArray()]];
       $users = $this->user->getItemsBy(json_decode(json_encode($params)));

      foreach ($result as $item) {

        $ad = $ads->where("id",$item->ad_id)->first();

        $user = $users->where("id",$ad->user_id)->first();
        $up = $ups->where("id",$item->up_id)->first();

          \Log::info("ADUP {$item->id} of the Ad Id {$ad->id}: of the User: {$user->email} ({$user->id}) - Days Remaining: {$item->days_remaining}");

          $this->notification->to([
            "email" => $user->email,
            "broadcast" => $user->id,
            "push" => $user->id,
          ])->push(
            [
              "title" => $item->days_remaining > 0 ? trans("iad::adups.alerts.adUpForSellOut") : trans("iad::adups.alerts.adUpSoldOut"),
              "message" => $item->days_remaining > 0 ? trans("iad::adups.messages.adUpForSellOut", ["days" => $item->days_remaining, "upName" => $up->title, "adName" => $ad->title]) : trans("iad::adups.messages.adUpSoldOut",  ["days" => $item->days_remaining, "upName" => $up->title, "adName" => $ad->title]),
              "buttonText" => trans("iad::adups.button.buy"),
              "withButton" => true,
              "link" => route('pins.ad.by-up',["pinSlug" => $ad->slug]),
            ]
          );

      }
    }else{
      \Log::info("Nothing AD-UP to Expire");
    }

  }

}
