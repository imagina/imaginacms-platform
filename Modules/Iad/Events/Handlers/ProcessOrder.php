<?php

namespace Modules\Iad\Events\Handlers;


use Modules\Iad\Entities\Ad;
use Modules\Iad\Entities\AdUp;
use Modules\Iad\Entities\Up;

class ProcessOrder
{

    public function __construct()
    {

    }

    public function handle($event)
    {
        $order = $event->order;
        //Order is Proccesed
        if($order->status_id==13){

            foreach($order->orderItems as $item){

                switch($item->entity_type){
                  case 'Modules\Iad\Entities\Up':

                    $up = Up::find($item->entity_id);

                    $now = new \DateTime("now");
                    $fromDate = \DateTime::createFromFormat('Y-m-d', $item->options->fromDate) ?? $now;

                    $toDate = \DateTime::createFromFormat('Y-m-d', $item->options->toDate);

                    if(!$toDate){
                      $toDate = $fromDate;
                      $toDate->add(new \DateInterval("P".$up->days_limit."D"));
                    }

                    if(isset($item->options->fullDay) && $item->options->fullDay=="on"){
                      $fromHour = "00:00:00";
                      $toHour = "23:59:59";
                    }else{
                      $fromHour =$item->options->fromHour ?? "00:00:00";
                      $toHour = $item->options->toHour ?? "23:59:59";
                    }

                    if(isset($up->id)){
                      AdUp::create([
                        'ad_id' => $item->options->adId ?? null,
                        'up_id' => $up->id,
                        'days_limit' => $up->days_limit,
                        'ups_daily' => $up->ups_daily,
                        'status' => 1,
                        'order_id' => $order->id,
                        'days_counter' => 0,
                        'ups_counter' => 0,
                        'from_date' => $fromDate->format("Y-m-d"),
                        'to_date' =>$toDate->format("Y-m-d"),
                        'from_hour' => $fromHour,
                        'to_hour' => $toHour
                        ]
                    );
                    }


                    break;

                }

                if($item->product_id == config("asgard.iad.config.featuredProductId")){
                  $adId = $item->options->adId ?? null;
                  $ad = Ad::find($adId);

                  if(isset($ad->id)){
                    $ad->featured = true;
                    $ad->save();
                  }

                }
            }

        }// end If


    }// If handle



}
