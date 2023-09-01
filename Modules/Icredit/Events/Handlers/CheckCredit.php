<?php

namespace Modules\Icredit\Events\Handlers;

use Modules\Icredit\Repositories\CreditRepository;

class CheckCredit
{
    public $creditRepository;

    public function __construct(CreditRepository $creditRepository)
    {
        $this->creditRepository = $creditRepository;
    }

    public function handle($event)
    {
        try {
            // Credit status config
            $orderStatusSync = config('asgard.icredit.config.orderStatusSync');

            // Icommerce order entity
            $order = $event->order;
            \Log::info('Icredit: Events|Handler|CheckCredit|Order: '.$order->id);

            // finding credit object
            $params = ['filter' => ['field' => 'related_id', 'relatedType' => "Modules\Icommerce\Entities\Order"]];
            $credit = $this->creditRepository->getItem($order->id, json_decode(json_encode($params)));

            //if exist credit would be updated
            if (isset($credit->id)) {
                // updating credit object
                $this->creditRepository->updateBy($credit->id, [
                    //"amount" => $order->total,
                    'status' => $orderStatusSync[$order->status_id] ?? 3,
                ], null);
            } else {//else credit would be created
                //service to customize the amount to insert in the wallet
                $customService = setting('icredit::creditAmountCustomService', null, '');

                if (! empty($customService)) {
                    $customService = app($customService);
                    $data = $customService->getData($event) ?? null;
                }

                // creating credit object
                $dataToSave = [
                    'amount' => $data['amount'] ?? $order->total ?? 0,
                    'status' => $orderStatusSync[$order->status_id] ?? 3,
                    'related_id' => $order->id,
                    'related_type' => "Modules\Icommerce\Entities\Order",
                    'customer_id' => $data['userId'] ?? null,
                    'description' => trans('icredit::credits.descriptions.orderWasCreated', ['orderId' => $order->id]),
                ];

                $this->creditRepository->create($dataToSave);
            }
        } catch (\Exception $e) {
            \Log::error('Error | Handler | Event - CheckCredit: '.$e->getMessage()."\n".$e->getFile()."\n".$e->getLine().$e->getTraceAsString());
        }
    }
}
