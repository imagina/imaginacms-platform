<?php

namespace Modules\Iauctions\Events;

use Modules\User\Entities\Sentinel\User;

class WinnerWasSelected
{
    
    public $auction;
    public $bid;
    public $notificationService;
    
    public function __construct($bid)
    {
        $this->bid = $bid;
        $this->auction = $bid->auction;
        $this->notificationService = app("Modules\Notification\Services\Inotification");
        $this->notification();
    }


    public function notification()
    {

        \Log::info("Iauctions: Events|WinnerWasSelected|Notification");
        
        /*
        * Email to Winner Bid Provider
        * Email to Auction Responsable
        */
        $emailTo = [];
        array_push($emailTo,$this->bid->provider->email,$this->auction->user->email);
         
      

        //Emails from setting form-emails
        $emailsModule = json_decode(setting("iauctions::formEmails", null, "[]"));
        if (empty($emailsModule)) //validate if its a string separately by commas
            $emailsModule = explode(',', setting('iauctions::formEmails'));
        if($emailsModule[0]!="[]")
            $emailTo = array_merge($emailTo,$emailsModule);

        //Emails from users selected in the setting usersToNotify
        $usersToNotify = json_decode(setting("iauctions::usersToNotify", null, "[]"));
        $users = User::whereIn("id", $usersToNotify)->get();
        $usersEmails = $users->pluck('email')->toArray();
        $emailTo = array_merge($emailTo,$usersEmails);


        /*
        * broadcast to Winner Bid Provider
        * broadcast to Auction Responsable
        */
        $broadcastTo = [];
        array_push($broadcastTo,$this->bid->provider->id,$this->auction->user->id);

        //Broadcast Settings Users
        $broadcastTo = array_merge($broadcastTo,$users->pluck('id')->toArray());
        
        
        // Send Notification
        $this->notificationService->to([
            "email" => $emailTo,
            "broadcast" => $broadcastTo,
            "push" => $broadcastTo,
        ])->push([
            "title" => trans("iauctions::auctions.title.WinnerWasSelected",["auctionId" => $this->auction->id]),
            "message" => trans("iauctions::auctions.messages.WinnerWasSelected",
            [
                "auctionId" => $this->auction->id,
                "title" => $this->auction->title,
                "bidWinner" => $this->bid->provider->email
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

