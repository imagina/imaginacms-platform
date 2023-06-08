<?php

/**
* Get Payment Method Configuration
* @return collection
*/

if (!function_exists('paymentezGetConfiguration')) {

 	function paymentezGetConfiguration(){

        $paymentName = config('asgard.icommercepaymentez.config.paymentName');
        $attribute = array('name' => $paymentName);
        $paymentMethod = app("Modules\Icommerce\Repositories\PaymentMethodRepository")->findByAttributes($attribute); 
        
        return $paymentMethod;
    }

}

/**
* Encript url to reedirect
* @param  $orderID
* @param  $transactionID
* @return $url
*/
if (!function_exists('paymentezEncriptUrl')) {

     function paymentezEncriptUrl($orderID,$transactionID){

        $url = "{$orderID}-{$transactionID}";
        $encrip = base64_encode($url);

        return  $encrip;

    }
}

/**
* Decript url to get data   
* @param  $eUrl
* @return array
*/
if (!function_exists('paymentezDecriptUrl')) {

    function paymentezDecriptUrl($eUrl){

        $decrip = base64_decode($eUrl);
        $infor = explode('-',$decrip);
        
        return  $infor;

    }
}

/**
* Decript url to get data   
* @param  $eUrl
* @return array
*/
if (!function_exists('paymentezGetOrderDescription')) {

    function paymentezGetOrderDescription($order){

        $description = "Orden #{$order->id} - {$order->first_name} {$order->last_name}";
        
        return  $description;

    }
}