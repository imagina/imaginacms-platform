<?php

namespace Modules\Icredit\Entities;

use Modules\Core\Icrud\Entities\CrudModel;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Support\Str;

//Static Classes
use Modules\Icredit\Entities\Status;

class Credit extends CrudModel
{
  

  public $transformer = 'Modules\Icredit\Transformers\CreditTransformer';
  public $requestValidation = [
    'create' => 'Modules\Icredit\Http\Requests\CreateCreditRequest',
    'update' => 'Modules\Icredit\Http\Requests\UpdateCreditRequest',
    'withdrawalFunds' => 'Modules\Icredit\Http\Requests\WithdrawalFundsCreditRequest'
  ];

  protected $table = 'icredit__credits';
  protected $fillable = [
    'description',
    'customer_id',
    'admin_id',
    'status',
    'date',
    'amount',
    'related_id',
    'related_type',
  ];

  public function customer()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
  }

  //============== MUTATORS / ACCESORS ==============//

  public function getStatusNameAttribute()
  {
        $status = new Status();
        return $status->get($this->status);
  }

  public function getOptioqnsAttribute($value)
  {
    try {
      return json_decode(json_decode($value));
    } catch (\Exception $e) {
      return json_decode($value);
    }
  }
}
