<?php

/**
* Get Payment Method Configuration
* @return collection
*/

if (!function_exists('ipointGetConfiguration')) {

 	function ipointGetConfiguration(){

        $paymentName = config('asgard.ipoint.config.paymentName');
        
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
if (!function_exists('ipointEncriptUrl')) {

     function ipointEncriptUrl($orderID,$transactionID){

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
if (!function_exists('ipointDecriptUrl')) {

    function ipointDecriptUrl($eUrl){

        $decrip = base64_decode($eUrl);
        $infor = explode('-',$decrip);
        
        return  $infor;

    }
}