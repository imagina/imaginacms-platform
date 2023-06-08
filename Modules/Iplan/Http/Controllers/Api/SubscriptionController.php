<?php


namespace Modules\Iplan\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iplan\Events\SubscriptionHasStarted;
use Modules\Iplan\Http\Requests\CreateSubscriptionRequest;
use Modules\Iplan\Http\Requests\UpdateSubscriptionRequest;
use Modules\Iplan\Repositories\SubscriptionLimitRepository;
use Modules\Iplan\Repositories\SubscriptionRepository;
use Modules\Iplan\Repositories\PlanRepository;
use Modules\Iplan\Transformers\SubscriptionTransformer;
use Route;
use Carbon\Carbon;

class SubscriptionController extends BaseApiController
{
  private $subscription;
  private $plan;
  private $subscriptionLimit;

  private $subscriptionService;

  public function __construct(SubscriptionRepository      $subscription,
                              PlanRepository              $plan,
                              SubscriptionLimitRepository $subscriptionLimit)
  {
    parent::__construct();
    $this->subscription = $subscription;
    $this->plan = $plan;
    $this->subscriptionLimit = $subscriptionLimit;

    $this->subscriptionService = app('Modules\Iplan\Services\SubscriptionService');
  }


  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function index(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $dataEntity = $this->subscription->getItemsBy($params);

      //Response
      $response = [
        "data" => SubscriptionTransformer::collection($dataEntity)
      ];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $dataEntity = $this->subscription->getItem($criteria, $params);

      //Break if no found item
      if (!$dataEntity) throw new \Exception('Item not found', 404);

      //Response
      $response = ["data" => new SubscriptionTransformer($dataEntity)];

    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * CREATE A ITEM
   *
   * @param Request $request
   * @return mixed
   */
  public function create(Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get data
      $data = $request->input('attributes');
      $params = $this->getParamsRequest($request);
      $params->include = ['category', 'limits'];
      
      // Get Plan
      $plan = $this->plan->getItem($data['plan_id'], $params);

      // Validate plan exist
      if(empty($plan) || is_null($plan)){
        \Log::info(trans('iplan::plans.messages.plan not found'));
        throw new \Exception(trans('iplan::plans.messages.plan not found'), 400); 
      }

      // Data to save in Subscription
      $startDate = ($plan->trial>0) ? Carbon::now()->addDays($plan->trial) : Carbon::now();
      
      $totalDays = $plan->trial+$plan->frequency_id;
      $endDate =  Carbon::now()->addDays($totalDays);
      
      //$endDate = Carbon::now()->addDays($plan->frequency_id);
     
      $subscriptionData = [
        'name' => $plan->name,
        'description' => $plan->description,
        'category_name' => $plan->category->title,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'status' => 1,
      ];
      $data = array_merge($subscriptionData, $data);

      // Check if user has another subscription
      $oldSubscription = $this->subscriptionService->checkHasUserSuscription($data);

      // Only if plan type is Principal
      if($plan->type==0){

        // User has another subscription
        if(!is_null($oldSubscription)){
          
          //Update old subscription
          $entity = $this->subscription->updateBy($oldSubscription->id,$data);

          // Cumulative Plans
          $cumulative = setting('iplan::cumulativePlans',null, true);
          
          //Plans are not cumulative
          if($cumulative==false){
            
            foreach ($oldSubscription->limits as $key => $limit) {
              
              //The old limit should be inactive only if type is Principal (Like the plan)
              // the limits type 1 (Extra) should be actives
              if($limit->type==0){
                $limit->changed_subscription_date = $entity->start_date;
                $limit->save();
              }

            }
          }

        }else{
          $entity = $this->subscription->create($data);
        }
      }

      // Only if plan type is Extra (Like a package) - Is the same subscription
      if($plan->type==1){
        $entity = $oldSubscription;
      }

      // Subscription data to save in case it is updated at any time, the limit does not lose that information
      $options['subscription'] = [
        'name' => $entity->name,
        'description' => $entity->description,
        'category' => $entity->category_name,
        'start_date' => $entity->start_date,
        'end_date' => $entity->end_date
      ];

      // Create Subscription Limits
      foreach ($plan->limits as $limit) {
        $limitData = [
          'name' => $limit->name,
          'entity' => $limit->entity,
          'quantity' => $limit->quantity,
          'quantity_used' => 0,
          'attribute' => $limit->attribute,
          'attribute_value' => $limit->attribute_value,
          'start_date' => $entity->start_date,
          'end_date' => $entity->end_date,
          'type' => $plan->type,
          'options' => $options,
          'subscription_id' => $entity->id
        ];
        $this->subscriptionLimit->create($limitData);
      }

      event(new SubscriptionHasStarted($entity));
      

      //Response
      $response = ["data" => $entity];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {

      //dd($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * UPDATE ITEM
   *
   * @param $criteria
   * @param Request $request
   * @return mixed
   */
  public function update($criteria, Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      //Get data
      $data = $request->input('attributes');

      //Validate Request
      $this->validateRequestApi(new UpdateSubscriptionRequest((array)$data));

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $entity = $this->subscription->updateBy($criteria, $data, $params);

      //Response
      $response = ["data" => 'Item Updated'];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }


  /**
   * DELETE A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function delete($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);

      //call Method delete
      $this->subscription->deleteBy($criteria, $params);

      //Response
      $response = ["data" => ""];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function entities(Request $request)
  {
    try {

      $data = config('asgard.iplan.config.subscriptionEntities');

      //Response
      $response = [
        "data" => $data,
      ];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function me(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      $params->filter->user = auth()->user()->id;

      //Request to Repository
      $dataEntity = $this->subscription->getItemsBy($params);

      //Response
      $response = [
        "data" => SubscriptionTransformer::collection($dataEntity)
      ];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * Buy subscription
   *
   * @param Request $request
   * @return void
   */
  public function buy(Request $request)
  {
    \DB::beginTransaction();
    try {
      $params = $this->getParamsRequest($request);//Get params
      $data = $request->input('attributes');//Get data

      //Get Plan
      $plan = $this->plan->getItem($data['plan_id'], json_decode(json_encode([
        "include" => ["product"],
        "filter" => ["status" => 1]
      ])));

      //Validate if exist plan
      if (!$plan) {
        $status = 500;
        $response = ["messages" => [["message" => trans('iplan::common.planNotFound'), "type" => "error"]]];
      } else {
        //Get user
        $user = \Auth::user();
        //Create subscription
        if (!isset($plan->product) || !$plan->product->price || $plan->trial>0) {
          $this->create(new Request([
            'attributes' => [
              'entity' => "Modules\\User\\Entities\\" . config('asgard.user.config.driver') . "\\User",
              'entity_id' => $user->id,
              'plan_id' => $plan->id,
              'options' => $data,
            ]
          ]));

          if($plan->trial>0) 
            $redirectTo = url('/');

        } //Create cart to pay
        else {
          //Instance cart service
          $cartService = app("Modules\Icommerce\Services\CartService");
          //Create cart
          $cartService->create([
            "products" => [["id" => $plan->product->id, "quantity" => 1, "options" => $data]]
          ]);
          //Set redirect to cart
          $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
          $redirectTo = route($locale . '.icommerce.store.checkout');
        }

        \DB::commit(); //Commit to Data Base
        $response = ["data" => ["redirectTo" => $redirectTo ?? null]];
      }
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
      dd($response, $e->getLine(), $e->getFile());
    }
    //Return response
    return response()->json($response, $status ?? 200);
  }
}
