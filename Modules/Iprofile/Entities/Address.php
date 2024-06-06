<?php

namespace Modules\Iprofile\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Fhia\Entities\BranchOffice;
use Modules\User\Entities\Sentinel\User;

class Address extends Model
{
    protected $table = 'iprofile__addresses';

    protected $fillable = [
      'user_id',
      'first_name',
      'last_name',
      'company',
      'address_1',
      'address_2',
      'telephone',
      'city',
      'city_id',
      'zip_code',
      'country',
      'country_id',
      'state',
      'state_id',
      'neighborhood',
      'neighborhood_id',
      'type',
      'default',
      'options'
    ];
  
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  
  public function user(){
    $this->belognsTo(User::class);
  }
}
