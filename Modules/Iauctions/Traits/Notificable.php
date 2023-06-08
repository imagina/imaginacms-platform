<?php

namespace Modules\Iauctions\Traits;


//Events
use Modules\Iauctions\Events\AuctionWasCreated;
use Modules\Iauctions\Events\AuctionWasActived;
use Modules\Iauctions\Events\AuctionWasFinished;
use Modules\Iauctions\Events\AuctionWasCanceled;
use Modules\Iauctions\Events\BidWasCreated;

/**
* Trait 
*/
trait Notificable
{


	/**
   	* Boot trait method
   	*/
	public static function bootNotificable()
	{

		
		//Listen event after create model
		static::createdWithBindings(function ($model) {
    		
    		switch (get_class($model)) {

    			//Auction
    			case 'Modules\Iauctions\Entities\Auction':
    				// event(new AuctionWasCreated($model));
    				// Created and if is status active the one
    				$model->checkStatusAuction($model);
    				break;
    			
    			//Bid
    			case 'Modules\Iauctions\Entities\Bid':
    				event(new BidWasCreated($model));
    				break;

    		}
    		
		});

		//Listen event after updated model
		static::updatedWithBindings(function ($model) {
			switch (get_class($model)) {

    			//Auction
    			case 'Modules\Iauctions\Entities\Auction':
    				$model->checkStatusAuction($model);
    				break;

    			//Bid
    			case 'Modules\Iauctions\Entities\Bid':
    				$model->checkWinnerValue($model);
    				break;
    		
    		}
		});
	}

	/*
	* Check status Auction model
	*/
	public function checkStatusAuction($model){

		//ACTIVE
		if($model->status==1)
			event(new AuctionWasActived($model));

		//FINISHED
		if($model->status==2)
			event(new AuctionWasFinished($model));

		//CANCELED
		if($model->status==3)
			event(new AuctionWasCanceled($model));
    			

	}

	/*
	* Check Winner when update Bid Model
	*
	*/
	public function checkWinnerValue($bid){
		
		// Only Auctions type = OPEN
		// Bid Winner 1
		if($bid->auction->type==1 && $bid->winner){
			app('Modules\Iauctions\Services\AuctionService')->saveWinnerInAuction($bid);
		}
		
	}

	
}