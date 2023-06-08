<?php

namespace Modules\Icommercefreeshipping\Repositories\Eloquent;

use Modules\Icommercefreeshipping\Repositories\IcommerceFreeshippingRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentIcommerceFreeshippingRepository extends EloquentBaseRepository implements IcommerceFreeshippingRepository
{


    /**
     * Calculate Method
     * @param Parameters (cart_id,products) - products(array)[items,total]
     * @param Conf - Method configurations
     * @return
     */
    function calculate($parameters,$conf){
        
       
        $items = json_decode($parameters['products']['items']);
        $totalOrder = $parameters['products']['total'];


        $calculationType = config("asgard.icommercefreeshipping.config.calculeType");


        // Type Minimum Total from Order
        if($calculationType=="minimumTotalOrder"){
            if($totalOrder>=$conf->minimum){
                $response["msj"] = "success";
                $response["items"] = null;
                $response["price"] = 0;
                $response["priceshow"] = false;
            }else{
                $response = [
                    'status' => 'error',
                    'msj' => trans('icommercefreeshipping::icommercefreeshippings.messages.totalmininum')." ".formatMoney($conf->minimum)
                ];
            }

            return $response;
        }
       
        // If the product does not have freeshipping,
        // the total is sum to validate it with the minimum
        if($calculationType=="minimumTotalNotFreeshipping"){
            $totalCar = 0;

            foreach ($items as $item) {
                if ($item->freeshipping == 0) {
                    $totalCar = $totalCar + ($item->price * $item->quantity);
                }
            }

            if($totalCar>=$conf->minimum){

                $response["msj"] = "success";
                $response["items"] = null;
                $response["price"] = 0;
                $response["priceshow"] = false;

            }else{

                $response = [
                    'status' => 'error',
                    'msj' => trans('icommercefreeshipping::icommercefreeshippings.messages.totalmininum')." ".formatMoney($conf->minimum)
                ];
            
            }

            return $response;
        }
        
    }

}