<?php

namespace Modules\Ibooking\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Icrud\Entities\CrudModel;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

use Modules\Ibooking\Entities\Status;

use Modules\Ibooking\Traits\WithItems;

class Reservation extends CrudModel
{

  use WithItems; // Event to update status itemsssss
  //use BelongsToTenant;

  public $transformer = 'Modules\Ibooking\Transformers\ReservationTransformer';
  public $repository = 'Modules\Ibooking\Repositories\ReservationRepository';
  public $requestValidation = [
    'create' => 'Modules\Ibooking\Http\Requests\CreateReservationRequest',
    'update' => 'Modules\Ibooking\Http\Requests\UpdateReservationRequest',
  ];

  
  public $modelRelations = [
    'items' => 'hasMany'
  ];
 

  protected $table = 'ibooking__reservations';
  protected $casts = ['options' => 'array'];
  protected $fillable = [
    'customer_id',
    'status',
    'options'
  ];

  //============== RELATIONS ==============//

  public function items()
  {
    return $this->hasMany(ReservationItem::class);
  }

  public function customer()
  {
    $driver = config('asgard.user.config.driver');

    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
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


}
