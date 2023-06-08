<?php

/**
* Get Payment Method Configuration
* @return collection
*/

if (!function_exists('braintree_getPaymentMethodConfiguration')) {

 	function braintree_getPaymentMethodConfiguration(){

        $paymentName = config('asgard.icommercebraintree.config.paymentName');
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
if (!function_exists('braintree_encriptUrl')) {

     function braintree_encriptUrl($orderID,$transactionID){

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
if (!function_exists('braintree_decriptUrl')) {

    function braintree_decriptUrl($eUrl){

        $decrip = base64_decode($eUrl);
        $infor = explode('-',$decrip);
        
        return  $infor;

    }
}