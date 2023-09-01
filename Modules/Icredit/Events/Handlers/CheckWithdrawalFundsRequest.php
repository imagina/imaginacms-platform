<?php

namespace Modules\Icredit\Events\Handlers;

use Modules\Icredit\Repositories\CreditRepository;

class CheckWithdrawalFundsRequest
{
    public $creditRepository;

    public function __construct(CreditRepository $creditRepository)
    {
        $this->creditRepository = $creditRepository;
    }

    public function handle($event)
    {
        \Log::info('Icredit: Events|Handler|CheckWithdrawalFundsRequest');

        $requestable = $event->oldRequest;

        $credit = $this->creditRepository->getItem($requestable->id, json_decode(json_encode(['filter' => ['field' => 'related_id', 'relatedType' => get_class($requestable)]])));

        $credit->status = 2;
        $credit->description = trans('icredit::credits.descriptions.WithdrawalFundsRequestWasEffected', ['requestableId' => $requestable->id]);
        $credit->save();
    }
}
