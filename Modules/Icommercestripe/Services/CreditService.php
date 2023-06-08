<?php

namespace Modules\Icommercestripe\Services;

class CreditService
{

	private $stripeService;
	//private $creditService;

	public function __construct(){
    	$this->stripeService = app("Modules\Icommercestripe\Services\StripeService");
    	//$this->creditService = app("Modules\Icredit\Services\CreditService");
	}

	/*
	* Get data to create credit when order is created
	*/
	public function getData($event){
		
		\Log::info('Icommercestripe: CreditService|GetData');  

		// Data Init
		$data = [];
		$amount = 0;
		$order = $event->order;

		// Payment Method Configuration
        $paymentMethod = stripeGetConfiguration();
		// Currency Code from Config PaymentMethod
        $currencyAccount = $paymentMethod->options->currency;
        // Currency Value from Icommerce
        $currencyConvertionValue = stripeGetCurrencyValue($currencyAccount);

        \Log::info('Icommercestripe: CreditService|GetData|OrganizationId: '.$order->organization_id);

        if(!empty($order->organization_id)){

        	//Get account Id to destination transfer - Commented 04-03-2022
            /*
            $accountInfor = $this->stripeService->getAccountIdByOrganizationId($order->organization_id,true);
            */

            // Added 04-03-2022
            $organization = app("Modules\Isite\Repositories\OrganizationRepository")->where('id',$order->organization_id)->first();

            // Get the amount in the currency of the Main Account - Commented - 2021
            //$totalOrder = stripeGetAmountConvertion($order->currency_code,$currencyAccount,$order->total,$currencyConvertionValue);

            // Monto del Credito (En la moneda default del sitio)
            $totalOrder = $order->total;

            // Get Comision - Commented 04-03-2022
            /*
            $comision = $this->stripeService->getComisionToDestination($accountInfor['user'],$totalOrder);
            */

           

            // Get Comision - Added 04-03-2022
            $user = app("Modules\User\Repositories\UserRepository")->find($organization->user_id);
            $comision = $this->stripeService->getComisionToDestination($user,$totalOrder);

            //Amount to Transfer
            $data['amount'] = $totalOrder - $comision;

            //Commented 04-03-2022
            //$data['userId'] = $accountInfor['user']->id;

            // Added 04-03-2022
            $data['userId'] = $organization->user_id;
        }

		return $data;
	}

	/*
	* Create a Credit after transfer
	*/
	public function create($order,$accountInfor,$transfer,$orderParent){

		\Log::info('Icommercestripe: CreditService|CreateCredit'); 

		// Monto del Credito (En la moneda de la orden)
        $totalOrder = $order->total;
        
        // Get Comision
        $comision = $this->stripeService->getComisionToDestination($accountInfor['user'],$totalOrder);

        //Amount Credit
        $amountCredit = $totalOrder - $comision;

        $descriptionCredit = 'Transferencia Stripe: '.$transfer->id.' para el accountId Stripe: '.$accountInfor['accountId'];

        // Save Credit - Order Child
        $dataToCredit = [
            'amount' => -$amountCredit,
            'customerId' => $accountInfor['user']->id,
            'description' => $descriptionCredit,
            'status' => 2,
            'relatedId' => $order->id,
            'relatedType' => get_class($order)
        ];
        //$credit = $this->creditService->create($dataToCredit);
        $credit = app("Modules\Icredit\Services\CreditService")->create($dataToCredit);


        // Save Credit - Order Padre
        $dataToCredit = [
            'amount' => -$amountCredit,
            'description' => $descriptionCredit,
            'status' => 2,
            'relatedId' => $orderParent->id,
            'relatedType' => get_class($order)
         ];
        //$credit = $this->creditService->create($dataToCredit);
        $credit = app("Modules\Icredit\Services\CreditService")->create($dataToCredit);


	}


}