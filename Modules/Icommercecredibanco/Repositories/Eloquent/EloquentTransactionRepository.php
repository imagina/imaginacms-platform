<?php

namespace Modules\Icommercecredibanco\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommercecredibanco\Repositories\TransactionRepository;

class EloquentTransactionRepository extends EloquentBaseRepository implements TransactionRepository
{
    /**
     * Generate Voucher
     *
     * @param    $order
     * @param    $arrayOut
     * @param    $type (1 = IcommerceCredibanco , 2 = Icredibanco)
     * @param    $config
     */
    //Deprecated
    /*
    public function create($order,$arrayOut,$type,$config){

        $data = array(
            'order_id' => $order->id,
            'order_status' => $order->order_status,
            'type' => $type,
            'commerceId' => $arrayOut['commerceId'],
            'operationDate' => $order->updated_at,
            'terminalCode' => $arrayOut['purchaseTerminalCode'],
            'operationNumber' => $arrayOut['purchaseOperationNumber'],
            'currency' =>  $config->options->currency,
            'amount' => $order->total,
            'tax' => (!empty($order->tax_amount)?$order->tax_amount:0),
            'description' => $arrayOut['additionalObservations'],
            'errorCode' => $arrayOut['errorCode'],
            'errorMessage' => $arrayOut['errorMessage'],
            'authorizationCode' => isset($arrayOut['authorizationCode'])?$arrayOut['authorizationCode']:'',
            'authorizationResult' => $arrayOut['authorizationResult']
         );

        $transaction = $this->model->create($data);

        return $transaction;

    }
    */
    public function findByOrder($id): transaction
    {
        return $this->model->where('order_id', '=', $id)->first();
    }

    public function findByOrderTrans($orderID, $transactionID)
    {
        return $this->model->where([
            ['id', '=', $transactionID], ['order_id', '=', $orderID],
        ])->first();
    }
}
