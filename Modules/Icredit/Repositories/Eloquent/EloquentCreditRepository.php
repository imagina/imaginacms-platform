<?php

namespace Modules\Icredit\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Icredit\Repositories\CreditRepository;

class EloquentCreditRepository extends EloquentCrudRepository implements CreditRepository
{
    /**
     * Filter name to replace
     *
     * @var array
     */
    protected $replaceFilters = [];

    /**
     * Filter query
     *
     * @return mixed
     */
    public function filterQuery($query, $filter, $params)
    {
        /**
         * Note: Add filter name to replaceFilters attribute to replace it
         *
         * Example filter Query
         * if (isset($filter->status)) $query->where('status', $filter->status);
         */

        // Filter amount Available
        if (isset($filter->amountAvailable)) {
            //custom select
            $query->select(
                'customer_id',
                \DB::raw('SUM(CASE WHEN status!=3 THEN amount ELSE 0 END) as amount'),
                \DB::raw('SUM(CASE WHEN status=2 and amount>=0 THEN amount ELSE 0 END) as amountIn'),
                \DB::raw('SUM(CASE WHEN status=2 and amount<0 THEN amount ELSE 0 END) as amountOut'),
                \DB::raw('SUM(CASE WHEN status=1 THEN amount ELSE 0 END) as amountPending'),
            );

            //group by client Id
            $query->groupBy('customer_id');
        }

        //Response
        return $query;
    }

    /**
     * Calculates in Checkout
     */
    public function calculate($parameters, $conf)
    {
        $response['status'] = 'success';

        // Search Cart
        if (isset($parameters['cartId'])) {
            $cartRepository = app('Modules\Icommerce\Repositories\CartRepository');
            $cart = $cartRepository->find($parameters['cartId']);
        }

        // Validating Min Amount Order
        if (isset($conf->minimunAmount) && ! empty($conf->minimunAmount)) {
            if (isset($cart->total) || isset($parameters['total'])) {
                if (($cart->total ?? $parameters['total']) < $conf->minimunAmount) {
                    $response['status'] = 'error';
                    $response['msj'] = trans('icommerce::common.validation.minimumAmount', ['minimumAmount' => formatMoney($conf->minimunAmount)]);

                    return $response;
                }
            }
        }

        //\Log::info('Icredit: EloquentCreditRepository|Calculate|Parameters: '.json_encode($parameters['extra']));

        //This validation will only be executed in the checkout or when is creating an order and not exist parentId (Is a Parent Order)
        if (! isset($parameters['extra']->parentId)) {
            // Validating User has credit
            $authUser = \Auth::user();
            if (isset($cart) && isset($authUser->id)) {
                $paymentService = app('Modules\Icredit\Services\PaymentService');

                //Process Payment Valid
                $result = $paymentService->validateProcessPayment($authUser->id, $cart->total);

                //\Log::info('Icredit: EloquentCreditRepository|Calculate|ProcessPayment: '.$result['processPayment']);

                if ($result['processPayment'] == false) {
                    $response['status'] = 'error';
                    $response['msj'] = trans('icredit::icredit.validation.no credit', ['creditUser' => formatMoney($result['creditUser'])]);

                    return $response;
                }
            }
        }

        return $response;
    }
}
