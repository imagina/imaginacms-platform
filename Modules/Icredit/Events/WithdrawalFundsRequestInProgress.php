<?php

namespace Modules\Icredit\Events;

class WithdrawalFundsRequestInProgress
{
    public $requestable;

    public $oldRequest;

    public $notificationService;

    public $requestCreator;

    public function __construct($requestable, $oldRequest)
    {
        $this->requestable = $oldRequest;
        $this->oldRequest = $oldRequest;
        $this->notificationService = app("Modules\Notification\Services\Inotification");

        $this->notification();
    }

    public function notification()
    {
        //\Log::info('Icredit: Events|WithdrawalFundsRequestInProgress|Notification');

        $this->notificationService->to([
            'email' => $this->oldRequest->createdByUser->email,
            'broadcast' => $this->oldRequest->createdByUser->id,
            'push' => $this->oldRequest->createdByUser->id,
        ])->push(
            [
                'title' => trans('icredit::credits.title.WithdrawalFundsRequestInProgress'),
                'message' => trans('icredit::credits.messages.WithdrawalFundsRequestInProgress'),
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
