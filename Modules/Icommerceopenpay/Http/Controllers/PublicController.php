<?php

namespace Modules\Icommerceopenpay\Http\Controllers;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base
use Modules\Core\Http\Controllers\BasePublicController;

use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerce\Repositories\OrderRepository;

// Services
use Modules\Icommerceopenpay\Services\OpenpayService;


class PublicController extends BasePublicController
{

    private $order;
    private $transaction;
    private $openpayService;

    public function __construct(
        OrderRepository $order,
        TransactionRepository $transaction,
        OpenpayService $openpayService
    )
    {
        $this->order = $order;
        $this->transaction = $transaction;
        $this->openpayService = $openpayService;
    }


    /**
     * Index data
     * @param Requests request
     * @return route
     */
    public function index($eURL){


        try {

            // Decr
            $infor = openpayDecriptUrl($eURL);
            $orderID = $infor[0];
            $transactionID = $infor[1];

            // Validate get data
            $order = $this->order->find($orderID);
            $transaction = $this->transaction->find($transactionID);
           
            // Get Payment Method Configuration
            $paymentMethod = openpayGetConfiguration();

            $config = $this->openpayService->makeConfiguration($paymentMethod,$order,$transaction);

            //View
            $tpl = 'icommerceopenpay::frontend.index';
          
            return view($tpl,compact('config'));


        } catch (\Exception $e) {

            \Log::error('Module Icommerceopenpay-Index: Message: '.$e->getMessage());
            \Log::error('Module Icommerceopenpay-Index: Code: '.$e->getCode());

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
