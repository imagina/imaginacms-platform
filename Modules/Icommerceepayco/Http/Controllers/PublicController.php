<?php

namespace Modules\Icommerceepayco\Http\Controllers;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base
use Modules\Core\Http\Controllers\BasePublicController;
// Repositories
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerceepayco\Repositories\IcommerceEpaycoRepository;

class PublicController extends BasePublicController
{
    private $icommerceepayco;

    private $paymentMethod;

    private $order;

    private $transaction;

    protected $urls;

    public function __construct(
        IcommerceEpaycoRepository $icommerceepayco,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        TransactionRepository $transaction
    ) {
        $this->icommerceepayco = $icommerceepayco;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->transaction = $transaction;

        $this->urls['sandbox'] = 'https://checkout.epayco.co/checkout.js';
        $this->urls['production'] = 'https://checkout.epayco.co/checkout.js';
    }

    /**
     * Index data
     *
     * @param Requests request
     */
    public function index($eURL)
    {
        try {
            // Decr
            $infor = icommerceepayco_decriptUrl($eURL);
            $orderID = $infor[0];
            $transactionID = $infor[1];

            //\Log::info('Module Icommerceepayco: Index-ID:'.$orderID);

            // Validate get data
            $order = $this->order->find($orderID);
            $transaction = $this->transaction->find($transactionID);

            // Get Payment Method Configuration
            $paymentMethod = icommerceepayco_getPaymentMethodConfiguration();

            // Epayco Service
            $epaycoService = app("Modules\Icommerceepayco\Services\EpaycoService");

            $config = $epaycoService->makeConfiguration($paymentMethod, $order, $transaction, $this->urls);

            //View
            $tpl = 'icommerceepayco::frontend.index';

            return view($tpl, compact('config'));
        } catch (\Exception $e) {
            \Log::error('Module Icommerceepayco-Index: Message: '.$e->getMessage());
            \Log::error('Module Icommerceepayco-Index: Code: '.$e->getCode());

            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
                'code' => $e->getCode(),
            ];

            return redirect()->route('homepage');
        }
    }

    /**
     * Response Frontend After the Payment
     */
    public function response(Request $request, $orderId)
    {
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        $isQuasarAPP = env('QUASAR_APP', false);

        if (isset($request->orderId)) {
            $order = $this->order->find($orderId);

            if (! $isQuasarAPP) {
                if (! empty($order)) {
                    return redirect($order->url);
                } else {
                    return redirect()->route('homepage');
                }
            } else {
                return view('icommerce::frontend.orders.closeWindow');
            }
        } else {
            if (! $isQuasarAPP) {
                return redirect()->route('homepage');
            } else {
                return view('icommerce::frontend.orders.closeWindow');
            }
        }
    }
}
