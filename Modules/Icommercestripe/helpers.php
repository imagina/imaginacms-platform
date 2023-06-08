<?php

/**
* Get Payment Method Configuration
* @return collection
*/

if (!function_exists('stripeGetConfiguration')) {

 	function stripeGetConfiguration(){

        $paymentName = config('asgard.icommercestripe.config.paymentName');
        $attribute = array('name' => $paymentName);
        $paymentMethod = app("Modules\Icommerce\Repositories\PaymentMethodRepository")->findByAttributes($attribute); 
        
        return $paymentMethod;
    }

}

/**
*   
* @param  
* @return
*/
if (!function_exists('stripeGetOrderDescription')) {

    function stripeGetOrderDescription($order){

        $description = "Orden #{$order->id} - {$order->first_name} {$order->last_name}";
        
        return  $description;

    }
}

/**
*    
* @param 
* @return
*/
if (!function_exists('stripeGetTransferGroup')) {

    function stripeGetTransferGroup($orderId,$transactionId){

        $description = "order-".$orderId."-transaction-".$transactionId;
        
        return  $description;

    }
}

/**
*    
* @param 
* @return
*/
if (!function_exists('stripeGetInforTransferGroup')) {

    function stripeGetInforTransferGroup($transferGroup){

        $infor = explode('-',$transferGroup);
        return  $infor;

    }
}

/**
*    
* @param 
* @return
*/
if (!function_exists('stripeValidateAccountRequirements')) {
    
    function stripeValidateAccountRequirements($stripeAccount){
        $validate = false;

        if($stripeAccount->details_submitted && $stripeAccount->charges_enabled && $stripeAccount->payouts_enabled)
            $validate = true;

        return $validate;
    }

}

/**
*    
* @param 
* @return
*/
if(!function_exists('stripeGetAmountConvertion')){
    function stripeGetAmountConvertion($orderCurrencyCode,$accountCurrencyCode,$amount,$currencyValue){
        
        // Need Convertion
        if($orderCurrencyCode!=$accountCurrencyCode){
            $totalItem = round($amount / $currencyValue,2);
        }else{
            $totalItem = $amount;
        }

        return $totalItem;
    }
}

/**
* Find Currency value to convertion in Icommerce with Currency Account
* @param 
* @return
*/
if(!function_exists('stripeGetCurrencyValue')){
    function stripeGetCurrencyValue($currencyAccount){
         
        $attributes = array('code'=> $currencyAccount);
        $currency = app('Modules\Icommerce\Repositories\CurrencyRepository')->findByAttributes($attributes);

        if($currency)
            return $currency->value;
        else
            throw new \Exception('Currency not found in Icommerce Module '.$currencyAccount, 500);
        
    }
}