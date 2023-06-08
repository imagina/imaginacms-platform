<?php

namespace Modules\Iauctions\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

use Modules\Iforms\Transformers\FormTransformer;
use Modules\Iforms\Entities\Form;

class CategoryTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {

  
    return [
      'auctionForm' => new FormTransformer($this->getDataForm($this->auction_form_id)),
      'bidForm' => new FormTransformer($this->getDataForm($this->bid_form_id)),
    ];
    

  }

  /*
  * Get Form
  */
  public function getDataForm($id){
    
    if(!is_null($id))
      return Form::where('id',$id)->first();
    else
      return null;

  }

  


}
