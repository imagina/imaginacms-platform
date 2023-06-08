<?php

namespace Modules\Iauctions\Services;

use Modules\Iauctions\Repositories\BidRepository;
use Modules\Iauctions\Repositories\AuctionRepository;

class BidService
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
    * Create a BID
    */
    public function create($data){

        
        // Validate exist Auction
        $auction = $this->auction->findByAttributes([
            'id'=> $data['auction_id']
        ]);
        if(is_null($auction))
            throw new \Exception(trans('iauctions::auctions.validation.not found'), 500);

        // Validate is Available
        if(!$auction->IsAvailable)
            throw new \Exception(trans('iauctions::auctions.validation.not available'), 500);

        // Validate Provider Id
        $data["provider_id"] = $data["provider_id"] ?? \Auth::id();

        //Validate if user doen't have Bids Actives
        $bids = $this->bid->findByAttributes([
            'provider_id'=> $data['provider_id'],
            'auction_id' => $auction->id,
            'status' => 1 //RECEIVED = 1;
        ]);
        if(!is_null($bids))
            throw new \Exception(trans('iauctions::auctions.validation.other bid'), 500);

        // Search if Auction category has a Bid Service to Calculate Points(Score)
        if(is_null($auction->category->bid_service)){
            $points = $data['amount'];
        }else{
            $infor = app($auction->category->bid_service)->getPointsWithExtraData($data,$auction);
            $points = $infor['points'];
            if(isset($infor['extraData']) && !is_null($infor['extraData']))
                $data = array_merge($data,$infor['extraData']);
        }

        $data['points'] = $points;

        // Create BID
        $model = $this->bid->create($data);
            
        return $model;

    }

}