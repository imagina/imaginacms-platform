<?php

/**
* Get Order Reference Commerce
* @param $order
* @param $transaction
* @return reference
*/
if (!function_exists('icommercepaypal_getOrderRefCommerce')) {

 	
    function icommercepaypal_getOrderRefCommerce($order,$transaction){


        $reference = $order->id."-".$transaction->id;

        return $reference;
    }

}

/**
* Get Payment Method Configuration
* @return collection
*/

if (!function_exists('icommercepaypal_getPaymentMethodConfiguration')) {

 	function icommercepaypal_getPaymentMethodConfiguration(){

        $paymentName = config('asgard.icommercepaypal.config.paymentName');
        $attribute = array('name' => $paymentName);
        $paymentMethod = app("Modules\Icommerce\Repositories\PaymentMethodRepository")->findByAttributes($attribute); 
        
        return $paymentMethod;
    }

}

/**
* Get Total Order Convertion in Currency Method
* @param  $order
* @param  $Payment Method Configuration
* @return total
*/
if (!function_exists('icommercepaypal_getOrderTotalConvertion')) {

	function icommercepaypal_getOrderTotalConvertion($order,$paymentMethod){
		
		$currenciesMethod = config('asgard.icommercepaypal.config.currencies');
		$total = $order->total;
		
		if(!array_search($order->currency_code,array_column($currenciesMethod,'value'))){

			$attributes = array('code'=>$paymentMethod->options->currency);
			$currency = app('Modules\Icommerce\Repositories\CurrencyRepository')->findByAttributes($attributes);

			if($currency){
				$total = round($order->total / $currency->value,2);
			}else{
				throw new \Exception('Currency not found to '.$paymentMethod->options->currency, 404);
			}
           
        }

       	return $total;
	}

}