<?php


namespace Modules\Iad\Events\Handlers;

use Modules\Iad\Entities\Ad;

class HandleAdStatuses
{

    public function handle($event){
        $userDriver = config('asgard.user.config.driver');
        $model = $event->model;

        if($model->entity === "Modules\\User\\Entities\\{$userDriver}\\User") {

            $adsToChange = 0;

            \Log::info("Changing Ad statuses from user: {$model->entityData->email}");

            foreach ($model->limits as $limit) {
                if ($limit->entity == Ad::class) {
                    $adsToChange += $limit->quantity;
                }
            }

            $adStatus = $model->status == 1 ? 2 : 0;

            Ad::where('user_id', $model->entity_id)
                ->take($adsToChange)
                ->orderBy('updated_at', 'asc')
                ->update(['status' => $adStatus]);



            \Log::info("Ad changed from user: {$model->entityData->email} > {$adsToChange} to status: {$adStatus}");
        }

    }
}
