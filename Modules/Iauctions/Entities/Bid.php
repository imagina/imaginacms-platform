<?php

namespace Modules\Iauctions\Entities;

use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Iauctions\Traits\Notificable;
//Static Classes

//Traits
use Modules\Ifillable\Traits\isFillable;
use Modules\Media\Support\Traits\MediaRelation;

class Bid extends CrudModel
{
    use isFillable, Notificable, MediaRelation;

    protected $table = 'iauctions__bids';

    public $transformer = 'Modules\Iauctions\Transformers\BidTransformer';

    public $repository = 'Modules\Iauctions\Repositories\BidRepository';

    public $requestValidation = [
        'create' => 'Modules\Iauctions\Http\Requests\CreateBidRequest',
        'update' => 'Modules\Iauctions\Http\Requests\UpdateBidRequest',
    ];

    protected $fillable = [
        'auction_id',
        'provider_id',
        'description',
        'amount',
        'points',
        'status',
        'winner',
        'options',
    ];

    protected $casts = ['options' => 'array'];

    //============== RELATIONS ==============//

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function provider()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'provider_id');
    }

    //============== MUTATORS / ACCESORS ==============//

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function getStatusNameAttribute()
    {
        $status = new StatusBid();

        return $status->get($this->status);
    }
}
