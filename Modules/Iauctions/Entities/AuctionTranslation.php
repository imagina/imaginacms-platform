<?php

namespace Modules\Iauctions\Entities;

use Illuminate\Database\Eloquent\Model;

class AuctionTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $table = 'iauctions__auction_translations';
}
