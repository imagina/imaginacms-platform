<?php

/**
 * Get Iso
 *
 * @param $currency
 * @return Code
 */
if (! function_exists('icommercecredibanco_currencyISO')) {
    function icommercecredibanco_currencyISO($currency)
    {
        $currency = strtoupper($currency);

        if ($currency == 'COP') {
            return 170;
        }

        if ($currency == 'USD') {
            return 840;
        }
    }
}

/**
 * Delete _es URL
 *
 * @param
 * @return newurl
 */
if (! function_exists('icommercecredibanco_processUrl')) {
    function icommercecredibanco_processUrl($url)
    {
        $caracter = '_es';
        $newUrl = str_replace($caracter, '', $url);

        return $newUrl;
    }
}

/**
 * Format total value
 *
 * @param $total
 * @return Total
 */
if (! function_exists('icommercecredibanco_formatTotal')) {
    function icommercecredibanco_formatTotal($total)
    {
        $newTotal = number_format($total, 0, '.', '');
        $newTotal2 = $newTotal.'00';

        return $newTotal2;
    }
}

/**
 * Format Card Number to Voucher
 *
 * @param $nroT
 * @return nroT
 */
if (! function_exists('icommercecredibanco_formatCardNumber')) {
    function icommercecredibanco_formatCardNumber($cardNumber)
    {
        $cardNumberBroked = explode('**', $cardNumber);
        $newNro = str_repeat('*', strlen($cardNumberBroked[0]));
        $newCardNumber = $newNro.'**'.$cardNumberBroked[1];

        return $newCardNumber;
    }
}

/**
 * Get Status Transaction To Voucher
 *
 * @param data
 * @return status
 */
if (! function_exists('icommercecredibanco_GetStatusTransaction')) {
    function icommercecredibanco_GetStatusTransaction($data)
    {
        $status = trans('icommercecredibanco::icommercecredibancos.statusTransaction.denied');
        if ($data->actionCode == 0 && (isset($data->cardAuthInfo->approvalCode) || (isset($data->paymentWay) && $data->paymentWay == 'PSE'))) {
            $status = trans('icommercecredibanco::icommercecredibancos.statusTransaction.approved');
        }

        return $status;
    }
}
