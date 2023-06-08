<?php

namespace Modules\Icommerceopenpay\Repositories\Eloquent;

use Illuminate\Support\Str;
use Modules\Icommerceopenpay\Repositories\IcommerceOpenpayRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentIcommerceOpenpayRepository extends EloquentBaseRepository implements IcommerceOpenpayRepository
{

	/**
     * Calculates in Checkout
     *
     * @param $parameters
     * @param $conf
     * @return 
     */
    public function calculate($parameters,$conf){
  
  
        $response["status"] = "success";

        // Search Cart
        if(isset($parameters["cartId"])){
          $cartRepository = app('Modules\Icommerce\Repositories\CartRepository');
          $cart = $cartRepository->find($parameters["cartId"]);
        }
    
        //validating Auth user if exist in the excluded Users For Maximum Amount
        $excludeUser = false;
        $authUser = \Auth::user();
        if(isset($authUser->id) && isset($conf->excludedUsersForMaximumAmount) && !empty($conf->excludedUsersForMaximumAmount)){
          if(in_array($authUser->id,$conf->excludedUsersForMaximumAmount)){
            $excludeUser = true;
          }
        }
    
        //if there have not to exclude any user
        if(!$excludeUser){
          if(isset($conf->maximumAmount) && !empty($conf->maximumAmount)) {
            if (isset($cart->total) || isset($parameters["total"]))
              if(($cart->total ?? $parameters["total"]) > $conf->maximumAmount){
                
                $response["status"] = "error";
                $response["msj"] = trans("icommerce::common.validation.maximumAmount",["maximumAmount" =>formatMoney($conf->maximumAmount)]);

                return $response;
              }
          }
        }

        // Validating Min Amount Order
        if(isset($conf->minimunAmount) && !empty($conf->minimunAmount)) {
            if (isset($cart->total) || isset($parameters["total"]))
              if(($cart->total ?? $parameters["total"]) < $conf->minimunAmount){
                
                $response["status"] = "error";
                $response["msj"] = trans("icommerce::common.validation.minimumAmount",["minimumAmount" =>formatMoney($conf->minimunAmount)]);

                return $response;
              }
        }
       

        return $response;
    
    }
   

}