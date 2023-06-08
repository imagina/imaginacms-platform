<?php

namespace Modules\Iauctions\Services;

use Modules\Iauctions\Repositories\BidRepository;
use Modules\Iauctions\Repositories\AuctionRepository;
use Modules\Iauctions\Events\WinnerWasSelected;

class AuctionService
{

    private $bid;
    private $auction;

    public function __construct(
        BidRepository $bid,
        AuctionRepository $auction
    ){
       $this->bid = $bid;
       $this->auction = $auction;
    }

    /*
    *  Get and Save Winner for the Auction
    */
    public function setWinner($auction){

        \Log::info("Iauctions: Services|AuctionService");
        
        //Only Type Inverse
        if($auction->type==0){

            // Only bids with status RECEIVED
            // Order By - By default Repository is: field:points / way:asc
            // Take 1 only first
            $params = ["filter" => ["status" => 1],"take" => 1];
            $bids = $this->bid->getItemsBy(json_decode(json_encode($params)));

            // Set Winner
            if(count($bids)>0){
                $bidWin = $bids[0];
                $bidWin->winner = true;
                $bidWin->save();
                $this->saveWinnerInAuction($bidWin);
            }
            

        }else{
            \Log::info("Iauctions: Services|AuctionService|AuctionId:".$auction->id."- No Conditions to set Winner for the Auction Type");
        }
      

    }

    /*
    *  Save Winner for the Auction
    */
    public function saveWinnerInAuction($bid){

        $bid->auction->winner_id = $bid->provider_id;
        $bid->auction->save();

        event(new WinnerWasSelected($bid));

    }

}