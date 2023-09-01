<?php

/**
 * Get Payment Method Configuration
 *
 * @return collection
 */
if (! function_exists('openpayGetConfiguration')) {
    function openpayGetConfiguration()
    {
        $paymentName = config('asgard.icommerceopenpay.config.paymentName');

        // Params to Get Item
        $params['filter'] = [
            'field' => 'name',
        ];
        $paymentMethod = app("Modules\Icommerce\Repositories\PaymentMethodRepository")->getItem($paymentName, json_decode(json_encode($params)));

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
if (! function_exists('openpayEncriptUrl')) {
    function openpayEncriptUrl($orderID, $transactionID)
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
if (! function_exists('openpayDecriptUrl')) {
    function openpayDecriptUrl($eUrl)
    {
        $decrip = base64_decode($eUrl);
        $infor = explode('-', $decrip);

        return  $infor;
    }
}

/**
 * @param    $eUrl
 * @return array
 */
if (! function_exists('openpayIsProductionMode')) {
    function openpayIsProductionMode($mode)
    {
        $isProduction = false;
        if ($mode != 'sandbox') {
            $isProduction = true;
        }

        return $isProduction;
    }
}

/**
 * Get Order Reference Commerce
 *
 * @param $order
 * @param $transaction
 * @return reference
 */
if (! function_exists('openpayGetOrderRefCommerce')) {
    function openpayGetOrderRefCommerce($order, $transaction)
    {
        /*
        * Important: If you redirect to PSE with an order number and try to redirect again with that same order number, Openpay returns the url for PSE but when you enter that URL it shows a 404.
        */
        $reference = $order->id.'-'.$transaction->id.'-'.time();
        //$reference = $order->id."-".$transaction->id;
        return $reference;
    }
}

/**
 * Get Infor Reference From Commerce
 *
 * @param $reference
 * @return array
 */
if (! function_exists('openpayGetInforRefCommerce')) {
    function openpayGetInforRefCommerce($reference)
    {
        $result = explode('-', $reference);

        $infor['orderId'] = $result[0];
        $infor['transactionId'] = $result[1];

        return $infor;
    }
}

/**
 * Decript url to get data
 *
 * @param    $eUrl
 * @return array
 */
if (! function_exists('openpayGetOrderDescription')) {
    function openpayGetOrderDescription($order)
    {
        $description = "Orden #{$order->id} - {$order->first_name} {$order->last_name}";

        return  $description;
    }
}
