<?php

namespace Modules\Iplan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use Modules\Iad\Entities\Ad;
use Route;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Core\Http\Controllers\BasePublicController;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

//Entities
use Modules\Iplan\Repositories\PlanRepository;
use Modules\Iplan\Repositories\CategoryRepository;

class PublicController extends BaseApiController
{
  private $plan;
  private $category;
  private $user;
  private $notification;
  private $subscriptionService;
  private $subscriptionRepository;

  public function __construct(
    PlanRepository $plan, CategoryRepository $category
  )
  {
    parent::__construct();
    $this->plan = $plan;
    $this->category = $category;
    $this->notification = app("Modules\Notification\Services\Inotification");
    $this->user = app("Modules\Iprofile\Repositories\UserApiRepository");
    $this->subscriptionService = app("Modules\Iplan\Services\SubscriptionService");
    $this->subscriptionRepository = app("Modules\Iplan\Repositories\SubscriptionRepository");
  }

  // view products by category
  public function index(Request $request)
  {

    $params = $this->getParamsRequest($request);

    $tpl = 'iplan::frontend.plan.index';
    $ttpl = 'iplan.plan.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;

    $params->filter->internal = 0;

    $plans = $this->plan->getItemsBy($params);

    //$dataRequest = $request->all();

    return view($tpl, compact('plans'));
  }

    // view products by category
    public function indexCategory($catSlug, Request $request)
    {

        $argv = explode("/", $request->path());
        $slug = end($argv);

        $params = $this->getParamsRequest($request);

        $catParams = [
            'include' => ['*'],
            'filter' => [
                'field' => 'slug'
            ]
        ];

        $catParams = json_decode(json_encode($catParams));

        $category = $this->category->getItem($catSlug, $catParams);

        if(!$category)
            return abort(404);

        $catFilter = [
            'category' => $category->id
        ];

        $params->filter = json_decode(json_encode($catFilter));


        $tpl = 'iplan::frontend.plan.index';
        $ttpl = 'iplan.plan.index';

        if (view()->exists($ttpl)) $tpl = $ttpl;

        $plans = $this->plan->getItemsBy($params);

        //$dataRequest = $request->all();

        return view($tpl, compact('plans','category'));
    }

    public function buyPlan(Request $request, $planId = null)
    {
        $cartService = app("Modules\Icommerce\Services\CartService");

        $data = $request->all();

        if(!$planId)
            $planId = $data['planId'] ?? null;

        if(empty($planId))
            return redirect()->back()->withErrors([trans('iplan::plans.messages.selectPlan')]);

        $params = json_decode(json_encode(
            [
                "include" => [],
                "filter" => [
                    "status" => 1
                ]
            ]
        ));
        $plan = $this->plan->getItem($planId, $params);

        if(!isset($plan->product) || $plan->product->price == 0){
          $user = \Auth::user();
          if(!isset($user->id)){
            return redirect()->route('account.register');
          }else{
   
            $userDriver = config('asgard.user.config.driver');
            
            $subscriptionController = app('Modules\Iplan\Http\Controllers\Api\SubscriptionController');
            //Create subscription
            request()->session()->put('subscriptedUser.id',$user->id);
            $subscriptionController->create(new Request([
              'attributes' => [
                'entity' => "Modules\\User\\Entities\\{$userDriver}\\User",
                'entity_id' => $user->id,
                'plan_id' => $plan->id,
                'options' => $data,
              ]
            ]));
            //Log
            \Log::info("Register subscription Id {$plan->id} to user ID {$user->id}");
  
            return redirect('/ipanel');
          }
        }

        $products =   [[
            "id" => $plan->product->id,
            "quantity" => 1,
            "options" => $data
        ]];

        if(isset($data["featured"])){
            array_push($products,[
                "id" => config("asgard.iad.config.featuredProductId"),
                "quantity" => 1,
                "options" => $data
            ]);
        }
        $cartService->create([
            "products" => $products
        ]);

        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        return redirect()->route($locale . '.icommerce.store.checkout');
    }

    public function validateUserSubscription($criteria){
        $user = $this->user->getItem($criteria,(object)[
            'take' => false,
            'include' => ['fields', 'roles']
        ]);

        if(!$user)
            return abort(404);

        $userValidSubscription = $this->subscriptionService->validate(new Ad(), $user);

        $fields = [];

        if (isset($user->fields) && !empty($user->fields)) {
            foreach ($user->fields as $f) {
                $fields[$f->name] = $f->value;
            }
        }

        $tpl = 'iplan::frontend.validate-user-subscription';
        $ttpl = 'iplan.validate-user-subscription';

        if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl, compact('user', 'fields','userValidSubscription'));
    }

    function mySubscriptions(){

        $user = $this->user->getItem(auth()->user()->id, (object)[
            'take' => false,
            'include' => ['fields', 'roles']
        ]);

        // Fix fields to frontend
        $fields = [];
        if (isset($user->fields) && !empty($user->fields)) {
            foreach ($user->fields as $f) {
                $fields[$f->name] = $f->value;
            }
        }

        $tpl = 'iplan::frontend.my-subscriptions';
        $ttpl = 'iplan.my-subscriptions';

        return view($tpl, compact('user','fields'));
    }

}
