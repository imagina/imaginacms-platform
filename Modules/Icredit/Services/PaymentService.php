<?php

namespace Modules\Icredit\Services;

use Modules\Icredit\Entities\Credit;
use Modules\Icredit\Repositories\CreditRepository;
use Illuminate\Http\Request;

class PaymentService
{

    public function __construct(
        CreditRepository $credit
    )
    {
        $this->credit = $credit;
    }

    /**
    * Get Credit User  
    * @param  $customer Id
    * @return
    */
    public function getCreditByUser($customerId){

        // Get Credit
        $criteria = $customerId;
        $params = [
            'filter' => [
                "field" => "customerId"
            ]
        ];
        $credit = $this->credit->getItem($criteria,$params);

        return $credit;
    }

    /**
    * Get 
    * @param  $customerId
    * @return
    */
    public function getCreditAvailableForUser($userId){

        $credit = 0;
        $credit = Credit::where('customer_id',$userId)->where('status',2)->sum('amount');
        //\Log::info('Icredit: Services|getCreditAvailableForUser|Credit: '.$credit);

        return $credit;
    }

    /**
    * Validate if process the payment  
    * @param  $credit
    * @param  $total
    * @return
    */
    public function validateProcessPayment($userId,$total){

        $processPayment = false;

        $creditUser = $this->getCreditAvailableForUser($userId);

        if($creditUser>=$total)
            $processPayment = true;
        
        // Response
        return [
            'processPayment' => $processPayment,
            'creditUser' => $creditUser  
        ];

    }

}