<?php

namespace Modules\Iprofile\View\Components;

use Illuminate\View\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddressCardItem extends Component
{
  public $address;
  public $addressesExtraFields;
  

  public function __construct($addressId = null, $address = null)
  {
    if(isset($address->id)){
      $this->address = $address;
    }elseif(!empty($addressId)){
      $this->address = $this->addressRepository()->getItem($addressId);
    }
    
    $this->addressesExtraFields =  json_decode(setting('iprofile::userAddressesExtraFields', null, "[]"));
  
  }
  
  
  private function addressRepository()
  {
    return app('Modules\Iprofile\Repositories\AddressRepository');
  }


  public function render()
  {
    $this->user = null;

   
    return view("iprofile::frontend.components.address-card-item");
  }
}
