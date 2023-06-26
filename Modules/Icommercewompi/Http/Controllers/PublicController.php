<?php

namespace Modules\Icommercewompi\Http\Controllers;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base
use Modules\Core\Http\Controllers\BasePublicController;
// Repositories
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommercewompi\Repositories\IcommerceWompiRepository;

class PublicController extends BasePublicController
{
    private $icommercewompi;

    private $paymentMethod;

    private $order;

    private $transaction;

    protected $urls;

    public function __construct(
        IcommerceWompiRepository $icommercewompi,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        TransactionRepository $transaction
    ) {
        $this->icommercewompi = $icommercewompi;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->transaction = $transaction;

        $this->urls['sandbox'] = 'https://checkout.wompi.co/p/';
        $this->urls['production'] = 'https://checkout.wompi.co/p/';
    }

    /**
     * Index data
     *
     * @param Requests request
     * @return route
     */
    public function index($eURL): route
    {
        try {
            // Decr
            $infor = icommercewompi_decriptUrl($eURL);
            $orderID = $infor[0];
            $transactionID = $infor[1];

            //\Log::info('Module Icommercewompi: Index-ID:'.$orderID);

            // Validate get data
            $order = $this->order->find($orderID);
            $transaction = $this->transaction->find($transactionID);

            // Get Payment Method Configuration
            $paymentMethod = icommercewompi_getPaymentMethodConfiguration();

            // Wompi Service
            $wompiService = app("Modules\Icommercewompi\Services\WompiService");

            $wompi = $wompiService->create($paymentMethod, $order, $transaction, $this->urls);

            $wompi->executeRedirection();
        } catch (\Exception $e) {
            \Log::error('Module Icommercewompi-Index: Message: '.$e->getMessage());
            \Log::error('Module Icommercewompi-Index: Code: '.$e->getCode());

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
     *
     * @param    $request (transaction wompi id)
     * @return redirect
     */
    public function response(Request $request, $orderId): redirect
    {
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        $isQuasarAPP = env('QUASAR_APP', false);

        if (isset($request->id)) {
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
