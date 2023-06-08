<?php

/**
* Get Payment Method Configuration
* @return collection
*/

if (!function_exists('icredit_getPaymentMethodConfiguration')) {

 	function icredit_getPaymentMethodConfiguration(){

        $paymentName = config('asgard.icredit.config.paymentName');
        
        // Params to Get Item
        $params['filter'] = [
            'field' => 'name'
        ];
        $paymentMethod = app("Modules\Icommerce\Repositories\PaymentMethodRepository")->getItem($paymentName,json_decode(json_encode($params)));
        
        return $paymentMethod;
    }

}

/**
* Encript url to reedirect
* @param  $orderID
* @param  $transactionID
* @return $url
*/
if (!function_exists('icredit_encriptUrl')) {

     function icredit_encriptUrl($orderID,$transactionID){

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
if (!function_exists('icredit_decriptUrl')) {

    function icredit_decriptUrl($eUrl){

        $decrip = base64_decode($eUrl);
        $infor = explode('-',$decrip);
        
        return  $infor;

    }
}