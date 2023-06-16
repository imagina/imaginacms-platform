<?php

namespace Modules\Iauctions\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Iauctions\Traits\Notificable;
//Static Classes

//Traits
use Modules\Icomments\Traits\Commentable;
use Modules\Ifillable\Traits\isFillable;
use Modules\Iprofile\Entities\Department;

class Auction extends CrudModel
{
    use isFillable, Translatable, Commentable, Notificable;

    protected $table = 'iauctions__auctions';

    public $transformer = 'Modules\Iauctions\Transformers\AuctionTransformer';

    public $repository = 'Modules\Iauctions\Repositories\AuctionRepository';

    public $requestValidation = [
        'create' => 'Modules\Iauctions\Http\Requests\CreateAuctionRequest',
        'update' => 'Modules\Iauctions\Http\Requests\UpdateAuctionRequest',
    ];

    public $translatedAttributes = [
        'title',
        'description',
    ];

    protected $fillable = [
        'status',
        'type',
        'user_id',
        'department_id',
        'start_at',
        'end_at',
        'category_id',
        'winner_id',
        'options',
    ];

    protected $casts = ['options' => 'array'];

    //============== RELATIONS ==============//

    // Responsable User
    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function winner()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'winner_id');
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
        $status = new Status();

        return $status->get($this->status);
    }

    public function getTypeNameAttribute()
    {
        $type = new AuctionTypes();

        return $type->get($this->type);
    }

    public function getIsAvailableAttribute()
    {
        $isAvailable = false;
        $today = date('Y-m-d H:i:s');
        //\Log::info("Today: ".$today);

        //ACTIVE = 1 and Between Dates
        if ($this->status == 1 && $this->start_at <= $today && $this->end_at >= $today) {
            $isAvailable = true;
        }

        return $isAvailable;
    }
}
