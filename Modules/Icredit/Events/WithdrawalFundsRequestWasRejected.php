<?php

namespace Modules\Icredit\Events;

use Modules\User\Entities\Sentinel\User;

class WithdrawalFundsRequestWasRejected
{
    public $requestable;

    public $oldRequest;

    public $notificationService;

    public function __construct($requestable, $oldRequest)
    {
        //\Log::info('Icredit: Events|WithdrawalFundsRequestWasRejected|Requestable: '.json_encode($requestable));

        $this->requestable = $requestable;
        $this->oldRequest = $oldRequest;
        $this->notificationService = app("Modules\Notification\Services\Inotification");

        $this->applyRejected();
        $this->notification();
    }

    private function applyRejected()
    {
        $credit = app("Modules\Icredit\Repositories\CreditRepository")->getItem($this->oldRequest->id, json_decode(json_encode(['filter' => ['field' => 'related_id', 'relatedType' => get_class($this->oldRequest)]])));

        $credit->status = 3;
        $credit->description = trans('icredit::credits.descriptions.WithdrawalFundsRequestWasRejected');
        $credit->save();
    }

    public function notification()
    {
        \Log::info('Icredit: Events|WithdrawalFundsRequestWasRejected|Notification');

        $emailTo = json_decode(setting('icommerce::form-emails', null, '[]'));
        $usersToNotity = json_decode(setting('icommerce::usersToNotify', null, '[]'));

        if (empty($emailTo)) {
            $emailTo = explode(',', setting('icommerce::form-emails'));
        }

        $users = User::whereIn('id', $usersToNotity)->get();
        $emailTo = array_merge($emailTo, $users->pluck('email')->toArray());

        $this->notificationService->to([
            'email' => $this->oldRequest->createdByUser->email,
            'broadcast' => $this->oldRequest->createdByUser->id,
            'push' => $this->oldRequest->createdByUser->id,
        ])->push(
            [
                'title' => trans('icredit::credits.title.WithdrawalFundsRequestWasRejected'),
                'message' => trans('icredit::credits.messages.WithdrawalFundsRequestWasRejected', ['requestableId' => $this->oldRequest->id, 'emailTo' => implode($emailTo, ',')]),
                'icon_class' => 'fa fa-bell',
                'withButton' => true,
                'link' => url('/ipanel/#/credit/wallet/'),
                'setting' => [
                    'saveInDatabase' => true,
                ],

            ]
        );
    }
}
