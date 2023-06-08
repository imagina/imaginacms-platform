<?php

namespace Modules\Icommercestripe\Services;

class StripeService
{

  private $fieldRepository;

	public function __construct(){
    $this->fieldRepository = app("Modules\Iprofile\Repositories\FieldRepository");
	}


  /**
  * Make Configuration to Payment
  * @param
  * @return Array
  */
  public function createConfigToTransferGroup($paymentMethod,$order,$transaction){


    // Meta Data
    $metaData = [
      "orderId" => $order->id,
      "transactionId" => $transaction->id
    ];

    // All Params
    $params = array(
      'customer_email' => $order->email,
      'payment_method_types' => ['card'],
      'line_items' => $this->getLineItems($order,$paymentMethod->options->currency),
      'payment_intent_data' => [
        'transfer_group' => stripeGetTransferGroup($order->id,$transaction->id),
        'description' => stripeGetOrderDescription($order),
        'metadata' => $metaData
      ],
      'mode' => 'payment',
      'success_url' => $order->url,
      'cancel_url' => url('/'),
      'metadata' => $metaData
      //'expand' => ['payment_intent']
    );

    return $params;

  }

  /**
  * Make Configuration Implementation Destination Charge
  * @param
  * @return Array
  */
	public function createConfigToDestinationCharge($paymentMethod,$order,$transaction){

    //All API requests expect amounts to be provided in a currency’s smallest unit
    //$amount = $order->total * 100;

    // Get Organization Id to First Item - All products have the same organization id
    $organizationId = $order->orderItems->first()->product->organization_id;

    //Comision
    $feeAmount = $paymentMethod->options->comisionAmount;
    $applicationFeeAmount = $feeAmount * 100;

    // Meta Data
    $metaData = [
      "orderId" => $order->id,
      "transactionId" => $transaction->id
    ];

    // All Params
		$params = array(
      'customer_email' => $order->email,
			'payment_method_types' => ['card'],
      'line_items' => $this->getLineItems($order),
      'payment_intent_data' => [
        'application_fee_amount' => $applicationFeeAmount,
        'transfer_data' => [
            'destination' => $this->getAccountIdByOrganizationId($organizationId),
        ],
        'description' => stripeGetOrderDescription($order),
        'metadata' => $metaData
      ],
      'mode' => 'payment',
      'success_url' => $order->url,
      'cancel_url' => url('/'),
      'metadata' => $metaData
		);

		return $params;

  }

  /**
  * Get Status to Order
  * @param
  * @return Int
  */
  public function getStatusDetail($event){

      \Log::info('Icommercestripe: getStatusDetail - Event Type: '.$event->type);

      // Check Event Type
      switch ($event->type) {

        case "checkout.session.completed":
          $newStatus = 13; //processed
        break;

        case "checkout.session.expired":
          $newStatus = 14; //expired
        break;

        default: // Fallida
          $newStatus = 7; //failed
        break;

      }
      $details['newStatus'] = $newStatus;

      // Check Values from Sesion
      $session = $event->data->object;
      //\Log::info('Icommercestripe: getStatusDetail - Session: '.$session);

      if($session->metadata){
        $details['orderId'] = $session->metadata->orderId;
        $details['transactionId'] = $session->metadata->orderId;
      }

      \Log::info('Icommercestripe: getStatusDetail - New Order Status: '.$newStatus);

      return $details;

  }


  /**
  * Get Line Items
  * @param
  * @return Int
  */
  public function getLineItems($order,$currencyAccount){


    $currencyConvertionValue = stripeGetCurrencyValue($currencyAccount);

    $items = [];
    foreach ($order->orderItems as $key => $item) {

      // Get the amount in the currency of the Main Account
      $totalItem = stripeGetAmountConvertion($order->currency_code,$currencyAccount,$item->price,$currencyConvertionValue);

      //$totalItem = $item->price;

      //All API requests expect amounts to be provided in a currency’s smallest unit
      $amountInCents = $totalItem * 100;

      $itemInfor['price_data'] = [
        'currency' => $currencyAccount,//$order->currency_code,
        'product_data' => [
          'name' => $item->product->name,
          'metadata' => ['id'=>$item->product->id]
        ],
        'unit_amount' => $amountInCents
      ];
      $itemInfor['quantity'] = $item->quantity;
      array_push($items, $itemInfor);

    }

    return $items;

  }


  /**
  * Find Configuration Payout User Profile Field
  * @param $userId - Optional
  * @return $model
  */
  public function findPayoutConfigUser($userId=null){

    if(is_null($userId))
      $userId = \Auth::id();

    // Check field for this user and name field
    $model = $this->fieldRepository
    ->where('name','=',config('asgard.icommercestripe.config.fieldName'))
    ->where('user_id', '=', $userId)
    ->first();

    return $model;

  }
  /**
  * Values to save or update in Configuration Payout User Profile Field
  * @param $payoutConfigValues - array
  * @return Model
  */
  public function syncDataUserField($payoutConfigValues){

    // Find Field
    $modelExist = $this->findPayoutConfigUser();

    // Update Field
    if($modelExist){

      $oldValues = json_decode(json_encode($modelExist->value),true);
      $dataField['value'] = array_merge($oldValues,$payoutConfigValues);

      $result = $this->fieldRepository->update($modelExist,$dataField);

    }else{

      // Create Field
      $dataField = [
        'user_id' => \Auth::id(),
        'name' => config('asgard.icommercestripe.config.fieldName'),
        'value' => $payoutConfigValues
      ];

      $result = $this->fieldRepository->create($dataField);

    }


    return $result;

  }

  /**
  * Get Account Id
  * @param $organizationId
  * @param $extraData Boolean
  * @return $accountId
  */
  public function getAccountIdByOrganizationId($organizationId,$extraData = false){

    $organization = app("Modules\Isite\Repositories\OrganizationRepository")->where('id',$organizationId)->first();

    $userConfig = $this->findPayoutConfigUser($organization->user_id);

    //\Log::info("getAccountIdByOrganizationId | User Config: ".json_encode($userConfig));

    //If the user doesn't have a stripe connect account
    if(is_null($userConfig))
      return null;

    // ExtraData is to get more information about user
    if($extraData){

      $data['accountId'] = $userConfig->value->accountId;
      $data['user'] = $userConfig->user;

      return $data;

    }else{

      return $userConfig->value->accountId;

    }


  }

  /**
  * Get Comision
  * @param $user (destination)
  * @return $comision
  */
  public function getComisionToDestination($user,$total){

    $comision = 0;

    //Just for testing
    $subscription = app("Modules\Iplan\Repositories\SubscriptionRepository")
    ->where('entity_id','=',$user->id)
    ->where('entity','=',get_class($user))
    ->orderBy('created_at', 'desc')
    ->first();

    //\Log::info('Icommercestripe: Response - Comision - Subscription: '.json_encode($subscription));

    //Falta - TODO no es necesario para Inmeet pero para otro caso puede aplicar
    //Si no tiene una subscripcion o un plan obtener la comision Final de los datos configurados en el crud field del modulo

    if($subscription){

      $typeDiscount = $subscription->plan->options->transactionFeeType;
      $value = $subscription->plan->options->transactionFeeAmount;

      //\Log::info('Icommercestripe: Response - Comision - TypeDiscount: '.$typeDiscount);

      if ($typeDiscount=="fixed"){
        $comision = $value;
      }

      if ($typeDiscount=="percentage"){
        $comision = $total * $value / 100;
      }

    }

    $comisionFinal = round($comision, 2);

    \Log::info('Icommercestripe: StripeService|GetComision: '.$comisionFinal);

    return $comisionFinal;
  }



}
