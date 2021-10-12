<?php

namespace Modules\Iprofile\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Fhia\Entities\BranchOffice;
use Modules\User\Entities\Sentinel\User;
use Modules\Ilocations\Entities\Country;
use Modules\Ilocations\Entities\Province;

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
    return $this->belongsTo(User::class);
  }
 
  public function countryIso2(){
    return $this->belongsTo(Country::class, 'country', 'iso_2');
  }
 
  public function provinceIso2(){
    return $this->belongsTo(Province::class, 'state', 'iso_2');
  }
  
  
  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }
  
  
  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }
  
}
