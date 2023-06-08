<?php

namespace Modules\Iplan\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Iplan\Entities\Subscription;
use Modules\Iplan\Events\SubscriptionHasFinished;

class FinishedSubscriptions implements ShouldQueue
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
        \Log::info("Iplan: Jobs|FinishedSubscriptions");

        $driver = config('asgard.user.config.driver');
        $userNamespace = "Modules\\User\\Entities\\{$driver}\\User";

        $nowDate = date('Y-m-d');
        $nowHour = date('H:i:00');

        $result = Subscription::select("id","status","end_date","entity_id")
        ->where("status", 1) //Active
        ->where("entity",$userNamespace)
        ->whereDate("end_date", $nowDate) // Only Subscriptions to Finish Today
        ->whereTime('end_date','<=', $nowHour) // Hour
        ->get();

        
        if(count($result) > 0) {
            $params = ["filter" => ["userId" => $result->pluck("entity_id")->toArray()]];
            $users = $this->user->getItemsBy(json_decode(json_encode($params)));

            \Log::info("Iplan: Jobs|FinishedSubscriptions|Results: ".count($result));

            // Each subscription expired
            foreach ($result as $item) {
                $user = $users->where("id",$item->entity_id)->first();

                //Update status subscription
                $model = Subscription::find($item->id);
                $model->status = 0;
                $model->save();
                event(new SubscriptionHasFinished($model));
                

                //send notification by email, broadcast and push -- by default only send by email
                $this->notification->to([
                    "email" => $user->email,
                    "broadcast" => $item->entity_id,
                    "push" => $item->entity_id,
                ])->push(
                    [
                        "title" => trans("iplan::subscriptions.alerts.subSoldOut"),
                        "message" => trans("iplan::subscriptions.messages.subSoldOut", ["name" => $item->name]),
                        "buttonText" => trans("iplan::plans.button.buy"),
                        "withButton" => true,
                        "link" => route(locale().'.iplan.plan.index'),
                    ]
                );
                
            }
        }

    }
}
