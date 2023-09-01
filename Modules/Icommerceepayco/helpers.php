<?php

/**
 * Encript url to reedirect
 *
 * @param    $orderID
 * @param    $transactionID
 * @return $url
 */
if (! function_exists('icommerceepayco_encriptUrl')) {
    function icommerceepayco_encriptUrl($orderID, $transactionID)
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
if (! function_exists('icommerceepayco_decriptUrl')) {
    function icommerceepayco_decriptUrl($eUrl)
    {
        $decrip = base64_decode($eUrl);
        $infor = explode('-', $decrip);

        return  $infor;
    }
}

/**
 * Get Order Reference Commerce
 *
 * @param $order
 * @param $transaction
 * @return reference
 */
if (! function_exists('icommerceepayco_getOrderRefCommerce')) {
    function icommerceepayco_getOrderRefCommerce($order, $transaction)
    {
        //Reference OJOO TIME JUST TESTING
        $reference = $order->id.'-'.$transaction->id.'-'.time();

        return $reference;
    }
}

/**
 * Get Infor Reference From Commerce
 *
 * @param $reference
 * @return array
 */
if (! function_exists('icommerceepayco_getInforRefCommerce')) {
    function icommerceepayco_getInforRefCommerce($reference)
    {
        $result = explode('-', $reference);

        $infor['orderId'] = $result[0];
        $infor['transactionId'] = $result[1];

        //\Log::info('Module Icommerceepayco: Reference Order Id: '.$infor['orderId']);
        //\Log::info('Module Icommerceepayco: Reference Transaction Id: '. $infor['transactionId']);

        return $infor;
    }
}

/**
 * Get Payment Method Configuration
 *
 * @return collection
 */
if (! function_exists('icommerceepayco_getPaymentMethodConfiguration')) {
    function icommerceepayco_getPaymentMethodConfiguration()
    {
        $paymentName = config('asgard.icommerceepayco.config.paymentName');
        $attribute = ['name' => $paymentName];
        $paymentMethod = app("Modules\Icommerce\Repositories\PaymentMethodRepository")->findByAttributes($attribute);

        return $paymentMethod;
    }
}
