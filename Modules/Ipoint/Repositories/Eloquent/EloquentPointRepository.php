<?php

namespace Modules\Ipoint\Repositories\Eloquent;

use Modules\Ipoint\Repositories\PointRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentPointRepository extends EloquentCrudRepository implements PointRepository
{
  /**
   * Filter names to replace
   * @var array
   */
  protected $replaceFilters = [];

  /**
   * Relation names to replace
   * @var array
   */
  protected $replaceSyncModelRelations = [];

  /**
   * Filter query
   *
   * @param $query
   * @param $filter
   * @return mixed
   */
  public function filterQuery($query, $filter, $params)
  {

    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */

    //Response
    return $query;
  }

  /**
   * Method to sync Model Relations
   *
   * @param $model ,$data
   * @return $model
   */
  public function syncModelRelations($model, $data)
  {
    //Get model relations data from attribute of model
    $modelRelationsData = ($model->modelRelations ?? []);

    /**
     * Note: Add relation name to replaceSyncModelRelations attribute before replace it
     *
     * Example to sync relations
     * if (array_key_exists(<relationName>, $data)){
     *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
     * }
     *
     */

    //Response
    return $model;
  }

  /**
     * Calculates in Checkout
     *
     * @param $parameters
     * @param $conf
     * @return 
     */
    public function calculate($parameters,$conf){
  
      //\Log::info('Ipoint: EloquentCalculate');
  
        $response["status"] = "success";

        // Search Cart
        if(isset($parameters["cartId"])){
          $cartRepository = app('Modules\Icommerce\Repositories\CartRepository');
          $cart = $cartRepository->find($parameters["cartId"]);
        }
    
        // Validating Min Amount Order
        if(isset($conf->minimunAmount) && !empty($conf->minimunAmount)) {
            if (isset($cart->total) || isset($parameters["total"]))
              if(($cart->total ?? $parameters["total"]) < $conf->minimunAmount){
                
                $response["status"] = "error";
                $response["msj"] = trans("icommerce::common.validation.minimumAmount",["minimumAmount" =>formatMoney($conf->minimunAmount)]);

                return $response;
              }
        }

        // Validating Puntos Insuficientes por parte del Usuario para pagar
        $authUser = \Auth::user();
        if(isset($cart) && isset($authUser->id)){
          //\Log::info('Ipoint: EloquentCalculate|Validation Points User');
          
            $paymentService = app('Modules\Ipoint\Services\PaymentService');
            
            // Process Payment Valid
            $result = $paymentService->validateProcessPayment($cart->products,$authUser->id);
            
            if($result['processPayment']==false){
                $response["status"] = "error";

                // Validate All items has points
                if($result['pointsItems']>0){
                  $response["msj"] = trans(
                  "ipoint::points.validation.no point",
                  [
                    "pointsUser" => $result['pointsUser'],
                    "pointsItems" => $result['pointsItems']
                  ]); 
                }else{
                   $response["msj"] = "Todos los productos seleccionados deben poseer puntos > 0";
                }
                

                return $response;
            }

        }
        
       
       
        return $response;
    
    }

}
