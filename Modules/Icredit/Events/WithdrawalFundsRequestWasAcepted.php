<?php

namespace Modules\Icredit\Events;

class WithdrawalFundsRequestWasAcepted
{
    public $requestable;

    public $oldRequest;

    public $notificationService;

    public $requestCreator;

    public function __construct($requestable, $oldRequest)
    {
        //\Log::info('Icredit: Events|WithdrawalFundsRequestWasAcepted|Requestable: '.json_encode($requestable));

        $this->requestable = $oldRequest;
        $this->oldRequest = $oldRequest;
        $this->notificationService = app("Modules\Notification\Services\Inotification");

        $this->notification();
    }

    public function notification()
    {
        //\Log::info('Icredit: Events|WithdrawalFundsRequestWasAcepted|Notification');

        $this->notificationService->to([
            'email' => $this->oldRequest->createdByUser->email,
            'broadcast' => $this->oldRequest->createdByUser->id,
            'push' => $this->oldRequest->createdByUser->id,
        ])->push(
            [
                'title' => trans('icredit::credits.title.WithdrawalFundsRequestWasAccepted'),
                'message' => ! empty($this->oldRequest->eta) ?
                  trans('icredit::credits.messages.WithdrawalFundsRequestWasAcceptedWithETA', ['requestableId' => $this->oldRequest->id, 'requestableETA' => $this->oldRequest->eta])
                  : trans('icredit::credits.messages.WithdrawalFundsRequestWasAccepted', ['requestableId' => $this->oldRequest->id]),
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
