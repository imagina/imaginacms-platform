<?php

namespace Modules\Iprofile\Http\Livewire;

use Livewire\Component;
use Modules\Iprofile\Entities\Address;

class AddressForm extends Component
{
  
  
  public $embedded;
  public $route;
  public $type;
  public $countries;
  public $provinces;
  public $cities;
  public $address;
  public $user;
  public $openInModal;
  protected $addressesExtraFields;
  
  protected $rules;
  
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function mount($embedded = false, $route = false, $type = null, $openInModal = false)
  {
    
    $this->embedded = $embedded;
    $this->openInModal = $openInModal;
    $this->route = $route;
    $this->type = $type;
    
    $this->addressesExtraFields =  json_decode(setting('iprofile::userAddressesExtraFields', null, "[]"));
    
    $this->initUser();
    $this->initAddress();
    $this->initCountries();
    $this->initProvinces();
    $this->initCities();

  }
  public function updated($name, $value){

    switch($name){
      case 'address.country':
        if(!empty($value)){
          $this->address["country_id"] = $this->countries->where("iso_2",$value)->first()->id;
          $this->initProvinces();
        }
    
        break;

        case 'address.state':
          if(!empty($value)) {
            $this->address["state_id"] = $this->provinces->where("iso_2", $value)->first()->id;
            $this->initCities();
          }
      break;
    }
  }
  
  public function save()
  {

    $this->validate($this->setRules(),$this->setMessages());
    
    $this->address["user_id"] = \Auth::user()->id ?? null;

    $this->address["city"] = $this->cities->where("id",$this->address["city_id"])->first()->name;
    
    $address = $this->addressRepository()->create($this->address);

    $this->emit('addressAdded', $address);
    
    $this->initAddress();
  
    $this->alert('success', trans('iprofile::addresses.messages.created'), config("asgard.isite.config.livewireAlerts"));
  
    
  }
  

  /**
   *
   */
  private function initUser()
  {
    $this->user = \Auth::user();
  }
  
  public function hydrate()
  {
    $this->rules = $this->setRules();
  }
  /**
   *
   */
  private function setRules()
  {
    $this->addressesExtraFields =  json_decode(setting('iprofile::userAddressesExtraFields', null, "[]"));
  $rules = [];
    foreach ($this->addressesExtraFields as $extraField){
    $rule = "";
      switch($extraField->type){
        case 'number':
          $rule = "numeric";
          break;
        case 'text':
          $rule = "string";
          break;
        case 'documentType':
          $rule = "string";
          $rules = array_merge($rules,["address.options.documentNumber" => $rule.($extraField->required ? "|required|min:6|max:10" : "")]);
          
          break;
        case 'textarea':
          $rule = "string|max:180";
          break;
      }
  
      if($extraField->required){
        $rule.= "|required";
      }
      if($extraField->active){
        $rules = array_merge($rules,["address.options.".$extraField->field => $rule]);
      }
    }
    
    return array_merge([
      'address.first_name' => 'required|string|min:3',
      'address.last_name' => 'required|string|min:3',
      'address.country' => 'required|string',
      'address.telephone' => 'required|min:5|max:10',
      'address.city_id' => 'required|integer',
      'address.state' => 'required|string',
      'address.default' => 'boolean',
      'address.address_1' => 'required|string|min:10',
      'address.type' => 'string'], $rules,);
    
  }
  
  
  private function setMessages(){
    return ([
      'address.options.documentNumber.min' => trans("iprofile::addresses.validation.documentNumber.min"),
      'address.options.documentNumber.max' => trans("iprofile::addresses.validation.documentNumber.max"),
      'address.first_name.min' => trans("iprofile::addresses.validation.first_name.min"),
      'address.last_name.min' => trans("iprofile::addresses.validation.last_name.min"),
      'address.address_1.min' => trans("iprofile::addresses.validation.address_1.min"),
      'address.telephone.min' => trans("iprofile::addresses.validation.telephone.min"),
      'address.telephone.max' => trans("iprofile::addresses.validation.telephone.max"),
      
      'address.first_name.required' => trans("iprofile::addresses.validation.required"),
      'address.last_name.required' => trans("iprofile::addresses.validation.required"),
      'address.address_1.required' => trans("iprofile::addresses.validation.required"),
      'address.country.required' => trans("iprofile::addresses.validation.required"),
      'address.city_id.required' => trans("iprofile::addresses.validation.required"),
      'address.state.required' => trans("iprofile::addresses.validation.required"),
      'address.telephone.required' => trans("iprofile::addresses.validation.required"),
      'address.options.documentNumber.required' => trans("iprofile::addresses.validation.required"),
      'address.options.documentType.required' => trans("iprofile::addresses.validation.required"),
    ]);
  }
  
  
  private function initAddress()
  {
    $this->addressesExtraFields =  json_decode(setting('iprofile::userAddressesExtraFields', null, "[]"));
  
    $options = [];
    foreach($this->addressesExtraFields as $extraField){
      if($extraField->active){
        if($extraField->field == "documentType"){
          $options["documentNumber"] = "";
        }
        $options[$extraField->field] = "";
      }
    }
    
    $this->address = [
      'first_name' => "",
      'last_name' => "",
      'address_1' => "",
      'telephone' => "",
      'country' => "",
      'country_id' => "",
      'state' => "",
      'city' => "",
      'city_id' => "",
      'default' => false,
      'user_id' => $this->user->id ?? null,
      'type' => $this->type,
      'options' => $options
    ];
  }
  
  private function initCountries()
  {
    $params = [];
    
    $this->countries = $this->countryRepository()->getItemsBy(json_decode(json_encode($params)));
    
    if($this->countries->count() == 1){
      $this->address["country"] = $this->countries->first()->iso_2;
      $this->address["country_id"] = $this->countries->first()->id;
    }
  }
  
  private function initProvinces()
  {
    
    if(isset($this->address["country_id"])){
      
      $params = ["filter" => ["countryId" => $this->address["country_id"] ?? null]];
      $this->provinces = $this->provinceRepository()->getItemsBy(json_decode(json_encode($params)));
      
    }else{
      $this->provinces = collect([]);
    }
  }
  
  private function initCities()
  {

    if(isset($this->address["state_id"])){
      
      $params = ["filter" => ["provinceId" => $this->address["state_id"] ?? null]];
      $this->cities = $this->cityRepository()->getItemsBy(json_decode(json_encode($params)));
      
    }else{
      $this->cities = collect([]);
    }
  }
  
  private function countryRepository()
  {
    return app('Modules\Ilocations\Repositories\CountryRepository');
  }
  
  private function provinceRepository()
  {
    return app('Modules\Ilocations\Repositories\ProvinceRepository');
  }
  
  private function cityRepository()
  {
    return app('Modules\Ilocations\Repositories\CityRepository');
  }
  
  private function addressRepository()
  {
    return app('Modules\Iprofile\Repositories\AddressRepository');
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|string
   */
  public function render()
  {
    return view("iprofile::frontend.livewire.address-form",[
      "addressesExtraFields" => $this->addressesExtraFields
    ]);
  }
}