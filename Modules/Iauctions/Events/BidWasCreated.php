<?php

namespace Modules\Iauctions\Events;

class BidWasCreated
{
    public $bid;

    public $notificationService;

    public function __construct($bid)
    {
        $this->bid = $bid;
        $this->notificationService = app("Modules\Notification\Services\Inotification");
        $this->notification();
    }

    public function notification()
    {
        \Log::info('Iauctions: Events|BidWasCreated|Notification');

        // Set emailTo Responsable
        $emailTo = $this->bid->auction->user->email;

        // Set BroadcastTo
        $broadcastTo = $this->bid->auction->user->email;

        // Send Notification
        $this->notificationService->to([
            'email' => $emailTo,
            'broadcast' => $broadcastTo,
            'push' => $broadcastTo,
        ])->push([
            'title' => trans('iauctions::bids.title.BidWasCreated', [
                'bidId' => $this->bid->id,
                'auctionInfor' => $this->bid->auction->id,
            ]),
            'message' => trans('iauctions::bids.messages.BidWasCreated',
                [
                    'bidId' => $this->bid->id,
                    'providerInfor' => $this->bid->provider->email,
                    'auctionInfor' => $this->bid->auction->title,
                ]),
            'icon_class' => 'fa fa-bell',
            'withButton' => true,
            'buttonText' => trans('iauctions::bids.single'),
            'link' => url('/ipanel/#/auctions/bids/index'),
            'setting' => [
                'saveInDatabase' => true,
            ],
        ]);
    }
}
