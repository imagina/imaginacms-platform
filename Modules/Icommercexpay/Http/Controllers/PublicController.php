<?php

namespace Modules\Icommercexpay\Http\Controllers;

// Requests & Response
use Illuminate\Http\Request;
// Base
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Repositories\OrderRepository;
// Repositories
use Modules\Icommercexpay\Http\Controllers\Api\IcommerceXpayApiController;
//Others
use Modules\Setting\Contracts\Setting;

class PublicController extends BasePublicController
{
    private $setting;

    private $xpayApiController;

    private $order;

    public function __construct(
        Setting $setting,
        IcommerceXpayApiController $xpayApiController,
        OrderRepository $order
    ) {
        $this->setting = $setting;
        $this->xpayApiController = $xpayApiController;
        $this->order = $order;
    }

    /**
     * index Public
     */
    public function index(Request $request)
    {
        // Init Data
        $resultInit = $this->initData($request);
        $data = $resultInit['data'];
        $dataError = $resultInit['dataError'];

        try {
            // GET TOKEN
            /*
            $response = $this->xpayApiController->getTokenLogin($request);
            $infor = $response->getData();

            if(isset($infor->data)){
                $data =  $infor->data;
            }else{
                throw new \Exception($infor->errors, 204);
            }
            */

            // GET CURRENCIES
            $response = $this->xpayApiController->getCurrencies(new Request([
                'order' => $data['order'],
            ]));

            // Response Fail
            if (isset($response->getData()->errors)) {
                throw new \Exception($response->getData()->errors, 204);
            }

            // Format OK Response
            $resData = json_decode($response->getData());

            if (isset($resData->available_currencies)) {
                $data['currencies'] = $resData->available_currencies;
            } else {
                throw new \Exception($resData->errors, 204);
            }
        } catch(\Exception $e) {
            //\Log::error('Module Icommercexpay - index: Message: '.$e->getMessage());
            //\Log::error('Module Icommercexpay - index: Code: '.$e->getCode());
            $dataError['status'] = true;
            $dataError['msj'] = json_encode($e->getMessage());
        }

        $tpl = 'icommercexpay::frontend.index';

        return view($tpl, compact('data', 'dataError'));
    }

    /**
     * Init Data Index
     *
     * @return array result
     */
    public function initData(Request $request)
    {
        $result = [];

        $data = [];
        $dataError['status'] = false;
        $dataError['msj'] = false;

        try {
            $infor = xpay_DecriptUrl($request->eUrl);
            $order = $this->order->find($infor[0]);

            $data['order'] = $order;
            $data['encrp'] = $request->eUrl;
        } catch(\Exception $e) {
            $dataError['status'] = true;
            $dataError['msj'] = json_encode($e->getMessage());
        }

        // Results
        $result['data'] = $data;
        $result['dataError'] = $dataError;

        return $result;
    }
}
