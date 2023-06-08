<?php

namespace Modules\Iauctions\Entities;


class AuctionTypes
{
    const INVERSE = 0;
    const OPEN = 1;
   
    private $auctionTypes = [];

    public function __construct()
    {
        $this->auctionTypes = [
            self::INVERSE => trans('iauctions::auctions.types.inverse'),
            self::OPEN => trans('iauctions::auctions.types.open'),
        ];
    }

    /**
     * Get the available statuses
     * @return array
     */
    public function lists()
    {
        return $this->auctionTypes;
    }

    
    public function get($statusId)
    {
        if (isset($this->auctionTypes[$statusId])) {
            return $this->auctionTypes[$statusId];
        }

        return $this->auctionTypes[self::INVERSE];
    }

}
