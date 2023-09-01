<?php

/**
 * Get Payment Method Configuration
 *
 * @return collection
 */
if (! function_exists('authorize_getPaymentMethodConfiguration')) {
    function authorize_getPaymentMethodConfiguration()
    {
        $paymentName = config('asgard.icommerceauthorize.config.paymentName');
        $attribute = ['name' => $paymentName];
        $paymentMethod = app("Modules\Icommerce\Repositories\PaymentMethodRepository")->findByAttributes($attribute);

        return $paymentMethod;
    }
}

/**
 * Encript url to reedirect
 *
 * @param    $orderID
 * @param    $transactionID
 * @return $url
 */
if (! function_exists('authorize_encriptUrl')) {
    function authorize_encriptUrl($orderID, $transactionID)
    {
        $url = "{$orderID}-{$transactionID}";
        $encrip = base64_encode($url);

        return  $encrip;
    }
}

/**
 * Decript url to get data
 *
 * @param    $eUrl
 * @return array
 */
if (! function_exists('authorize_decriptUrl')) {
    function authorize_decriptUrl($eUrl)
    {
        $decrip = base64_decode($eUrl);
        $infor = explode('-', $decrip);

        return  $infor;
    }
}
