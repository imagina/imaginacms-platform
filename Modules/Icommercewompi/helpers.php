<?php

/**
 * Encript url to reedirect
 *
 * @param    $orderID
 * @param    $transactionID
 * @return $url
 */
if (! function_exists('icommercewompi_encriptUrl')) {
    function icommercewompi_encriptUrl($orderID, $transactionID)
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
if (! function_exists('icommercewompi_decriptUrl')) {
    function icommercewompi_decriptUrl($eUrl)
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
if (! function_exists('icommercewompi_getOrderRefCommerce')) {
    function icommercewompi_getOrderRefCommerce($order, $transaction)
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
if (! function_exists('icommercewompi_getInforRefCommerce')) {
    function icommercewompi_getInforRefCommerce($reference)
    {
        $result = explode('-', $reference);

        $infor['orderId'] = $result[0];
        $infor['transactionId'] = $result[1];

        \Log::info('Module Icommercewompi: Reference Order Id: '.$infor['orderId']);
        \Log::info('Module Icommercewompi: Reference Transaction Id: '.$infor['transactionId']);

        return $infor;
    }
}

/**
 * Get Payment Method Configuration
 *
 * @return collection
 */
if (! function_exists('icommercewompi_getPaymentMethodConfiguration')) {
    function icommercewompi_getPaymentMethodConfiguration()
    {
        $paymentName = config('asgard.icommercewompi.config.paymentName');
        $attribute = ['name' => $paymentName];
        $paymentMethod = app("Modules\Icommerce\Repositories\PaymentMethodRepository")->findByAttributes($attribute);

        return $paymentMethod;
    }
}
