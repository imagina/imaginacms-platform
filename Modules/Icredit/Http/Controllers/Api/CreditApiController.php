<?php

namespace Modules\Icredit\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model Repository
use Modules\Icredit\Repositories\CreditRepository;
use Modules\Icredit\Entities\Credit;

use Illuminate\Http\Request;

//Transformer Requestable
use Modules\Requestable\Transformers\RequestableTransformer;

class CreditApiController extends BaseCrudController
{
    
    public $model;
    public $modelRepository;

    private $paymentService;

    public function __construct(Credit $model, CreditRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;

        $this->paymentService = app('Modules\Icredit\Services\PaymentService');
    }


    /**
    * WithdrawalFunds with Requestable Module
    * @param Request $attribute['amount']
    * @return Requestable Transformer
    */
    public function withdrawalFunds(Request $request)
    {
        \DB::beginTransaction();
        try {

            //Get model data
            $modelData = $request->input('attributes') ?? [];
          
            //Validate Request
            if (isset($this->model->requestValidation['withdrawalFunds'])) {
                $this->validateRequestApi(new $this->model->requestValidation['withdrawalFunds']($modelData));
            }

            
            // Process Payment Valid
            $authUser = \Auth::user();
            $resultValidate = $this->paymentService->validateProcessPayment($authUser->id,$modelData['amount']);

            if(!$resultValidate['processPayment'])
                throw new \Exception(trans("icredit::icredit.validation.no credit",['creditUser' => $resultValidate['creditUser']]), 500);


            // Requestable Service
            $modelData['type'] = "withdrawalFunds";
            $model = app('Modules\Requestable\Services\RequestableService')->create($modelData);

          app('Modules\Icredit\Services\CreditService')->create( [
            "amount" => $modelData["amount"]*-1 ?? 0,
            "customerId" => $authUser->id ?? null,
            "description" => trans("icredit::credits.descriptions.WithdrawalFundsRequestWasCreated",["requestableId" => $model->id]) ?? "",
            "status" => 1,
            "relatedId" => $model->id,
            "relatedType" => get_class($model)
          ]);
          
            //Response type Requestable Transformer
            $response = ["data" => new RequestableTransformer($model)];
          
            \DB::commit(); //Commit to Data Base

        } catch (\Exception $e) {

            \Log::error('Icredit: CreditApiController|withdrawalFunds|Message: '.$e->getMessage());

            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
          
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }


   
}
