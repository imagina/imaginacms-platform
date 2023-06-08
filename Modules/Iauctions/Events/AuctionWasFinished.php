<?php

namespace Modules\Iauctions\Events;

use Modules\User\Entities\Sentinel\User;

class AuctionWasFinished
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

        \Log::info("Iauctions: Events|AuctionWasFinished|Notification");
        
         // Set emailTo
        $emailTo = auctionsGetEmailTo($this->auction);
        // Set BroadcastTo
        $broadcastTo = auctionsGetBroadcastTo($this->auction);

        // Send Notification
        $this->notificationService->to([
            "email" => $emailTo,
            "broadcast" => $broadcastTo,
            "push" => $broadcastTo,
        ])->push([
            "title" => trans("iauctions::auctions.title.AuctionWasFinished",["auctionId" => $this->auction->id]),
            "message" => trans("iauctions::auctions.messages.AuctionWasFinished",
            [
                "auctionId" => $this->auction->id,
                "title" => $this->auction->title
            ]),
            "icon_class" => "fa fa-bell",
            "withButton" => true,
            "buttonText" => trans("iauctions::auctions.single"),
            "link" => url('/ipanel/#/auctions/auctions/index'),
            "setting" => [
                "saveInDatabase" => true
            ]
        ]);

    }

}