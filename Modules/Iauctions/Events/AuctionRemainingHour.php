<?php

namespace Modules\Iauctions\Events;

class AuctionRemainingHour
{
    public $auction;

    public $notificationService;

    public function __construct($auction)
    {
        $this->auction = $auction;
        $this->notificationService = app("Modules\Notification\Services\Inotification");
        $this->notification();
    }

    public function notification()
    {
        \Log::info('Iauctions: Events|AuctionRemainingHour|Notification');

        // Set emailTo
        $emailTo = auctionsGetEmailTo($this->auction);
        // Set BroadcastTo
        $broadcastTo = auctionsGetBroadcastTo($this->auction);

        //FormatDates to email
        $formatStartAt = date(config('asgard.iauctions.config.hourFormat'), strtotime($this->auction->start_at));
        $formatEndAt = date(config('asgard.iauctions.config.hourFormat'), strtotime($this->auction->end_at));

        // Send Notification
        $this->notificationService->to([
            'email' => $emailTo,
            'broadcast' => $broadcastTo,
            'push' => $broadcastTo,
        ])->push([
            'title' => trans('iauctions::auctions.title.AuctionRemainingHour', ['auctionId' => $this->auction->id]),
            'message' => trans('iauctions::auctions.messages.AuctionRemainingHour',
                [
                    'auctionId' => $this->auction->id,
                    'title' => $this->auction->title,
                    'endAt' => $formatEndAt,
                ]),
            'icon_class' => 'fa fa-bell',
            'withButton' => true,
            'buttonText' => trans('iauctions::auctions.single'),
            'link' => url('/ipanel/#/auctions/auctions/index'),
            'setting' => [
                'saveInDatabase' => true,
            ],
        ]);
    }
}
