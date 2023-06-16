<?php

/**
 * Encript url to reedirect
 *
 * @param    $orderID
 * @param    $transactionID
 * @return $url
 */
if (! function_exists('xpay_EncriptUrl')) {
    function xpay_EncriptUrl($params)
    {
        $url = "{$params['orderID']}-{$params['transactionID']}-".time();
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
if (! function_exists('xpay_DecriptUrl')) {
    function xpay_DecriptUrl($eUrl)
    {
        $decrip = base64_decode($eUrl);
        $infor = explode('-', $decrip);

        return  $infor;
    }
}
