<?php

namespace Modules\Icredit\Http\Controllers;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base
use Modules\Core\Http\Controllers\BasePublicController;

use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerce\Repositories\OrderRepository;


class PublicController extends BasePublicController
{

    private $order;
    private $transaction;
    private $paymentService;


    public function __construct(
        OrderRepository $order,
        TransactionRepository $transaction
    )
    {
        $this->order = $order;
        $this->transaction = $transaction;
        $this->paymentService = app('Modules\Icredit\Services\PaymentService');
    }


    /**
     * Index data
     * @param Requests request
     * @return route
     */
    public function paymentIndex($eURL){

        try {

            // Decr
            $infor = icredit_decriptUrl($eURL);
            $orderID = $infor[0];
            $transactionID = $infor[1];
            
            // Validate get data
            $order = $this->order->find($orderID);
            $transaction = $this->transaction->find($transactionID);
        
            // Process Payment Valid
            $authUser = \Auth::user();
            $resultValidate = $this->paymentService->validateProcessPayment($authUser->id,$order->total);

            //View
            $tpl = 'icredit::frontend.payment.index';

            return view($tpl,compact('order','resultValidate','eURL'));

        } catch (\Exception $e) {

            \Log::error('Icredit: paymentIndex|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());

            //Message Error
            $status = 500;
            $response = [
              'errors' => $e->getMessage(),
              'code' => $e->getCode()
            ];

            return redirect()->route("homepage");

        }

    }



}
