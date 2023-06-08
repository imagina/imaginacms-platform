<?php


namespace Modules\Iplan\Events\Handlers;


use Modules\Iplan\Entities\Limit;
use Modules\Iplan\Entities\SubscriptionLimit;
use Modules\Iplan\Entities\Subscription;
use Carbon\Carbon;

class HandleModulesLimits
{
  private $logTitle;
  private $subscriptionLimit;
  private $subscription;
  private $permissionsApiController;

  public function __construct()
  {
    $this->logTitle = '[Iplan-Validate-Limit-Event]::';
    $this->subscriptionLimit = app('Modules\Iplan\Repositories\SubscriptionLimitRepository');
    $this->subscription = app('Modules\Iplan\Repositories\SubscriptionRepository');
    $this->permissionsApiController = app("Modules\Ihelpers\Http\Controllers\Api\PermissionsApiController");
  }

  //Handle to "IsCreating"
  public function handleIsCreating($event)
  {
    $this->validateLimits($event, 'isCreating');
  }

  //Handle to "WasCreated"
  public function handleWasCreated($event)
  {
    $this->handleLimits($event, 'wasCreated');
  }

  //Handle to "IsUpdating"
  public function handleIsUpdating($event)
  {
    $this->validateLimits($event, 'isUpdating');
  }

  //Handle to "WasUpdated"
  public function handleWasUpdated($event)
  {
    $this->handleLimits($event, 'wasUpdated');
  }

  //Handle to "IsDeleting"
  public function handleIsDeleting($event)
  {
     $this->validateLimits($event, 'isDeleting');
  }

  //Handle to "WasDeleted"
  public function handleWasDeleted($event)
  {
     $this->handleLimits($event, 'wasDeleted');
  }

  //Main Handle
  public function validateLimits($event, $eventType)
  {
    $model = $event->model;//Get model

    $allowedLimits = true;//Defualt response

    $userDriver = config('asgard.user.config.driver');

    //Get entity attributes
    $entityNamespace = get_class($model);
    $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
    $moduleName = $entityNamespaceExploded[1];//Get module name
    $entityName = $entityNamespaceExploded[3];//Get entity name

    //Validate if exist plan limits to current entity (if not found, allow trigger action)
    $existEntityLimits = Limit::where('entity', $entityNamespace)->count();

    \Log::info("Exist Entity Limits => ". $existEntityLimits);

    //Validate user limits
    if ($existEntityLimits) {
      //Get user limits
      $userSubcriptionLimits = SubscriptionLimit::whereHas('subscription', function ($q) use($userDriver,$model) {
        //Get current full date
        $now = Carbon::now()->format('Y-m-d h:i:s');
        //Filter subscriptions
        $q->whereDate('end_date', '>', $now)->whereDate('start_date', '<=', $now)->where(function ($query) use($userDriver, $model) {
          $query->whereNull('entity')->orWhere(function ($query) use($userDriver, $model) {
            $query->where('entity_id', $model->customer_id ?? $model->user_id ?? auth()->user()->id)->where('entity', "Modules\\User\\Entities\\{$userDriver}\\User");
          });
        })->where('status',1);
      })
        ->orderBy('id')
        ->where('entity', $entityNamespace)
        ->get();

      //validate limits
      if ($userSubcriptionLimits->count() > 0) {
        $subscriptionToValidate = null;
        foreach ($userSubcriptionLimits as $k=>$limitToValidate) {
          $validateLimit = true;
          $modelValue = null;
          $limitAttribute = $limitToValidate->attribute; //get limit attribute name
          //Validate if limit has attribute
          if ($limitAttribute && isset($model->$limitAttribute)) {
            $modelValue = (string)$model->$limitAttribute ?? null;
            if ($modelValue != $limitToValidate->attribute_value) $validateLimit = false;
          }
          //validate limit quantities
          if ($validateLimit) {
            if ($eventType === 'isCreating' && ((int)$limitToValidate->quantity_used >= (int)$limitToValidate->quantity) && ((int)$limitToValidate->quantity > -1)) {
              $allowedLimits = false;
              continue;//end loop
            }else{
                if(empty($subscriptionToValidate)) $subscriptionToValidate = $limitToValidate->subscription_id;
                $quantityToChange = $limitToValidate->quantity_used;
                if ($eventType === 'isCreating') {
                    $quantityToChange++;
                }
                if ($eventType === 'isDeleting') {
                    $quantityToChange--;
                }
                $this->subscriptionLimit->updateBy($limitToValidate->id, ['quantity_used' => $quantityToChange]);
                $allowedLimits = true;
                break;
            }
          }
        }
      } else {
        /*
         * TODO: mejorar esta lógica mas adelante, aquí se dejó el permiso de acceso al iadmin para permitir que un
         *  administrador pueda crear las entidades que necesite sin limitaciones, por ahora para lo que se necesita
         *  funciona pero podría hacerse mejor
        */
        $userPermissions = $this->permissionsApiController->getAll(['userId' => auth()->user()->id]);
        if (!isset($userPermissions["profile.access.iadmin"]) || !$userPermissions["profile.access.iadmin"])
          $allowedLimits = false;
      }
    }
    \Log::info('Allowed Limits > '.$allowedLimits);
    //Response forbidden
    if (!$allowedLimits) throw new \Exception(trans('iplan::common.messages.entity-create-not-allowed'), 403);
  }

  //Handle limits after trigger event
  public function handleLimits($event, $eventType)
  {
    $model = $event->model;
    if($eventType === 'wasCreated'){
        //Get entity attributes
        $userDriver = config('asgard.user.config.driver');
        $entityNamespace = get_class($model);
        $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
        $moduleName = $entityNamespaceExploded[1];//Get module name
        $entityName = $entityNamespaceExploded[3];//Get entity name
        //Get current full date
        $now = Carbon::now()->format('Y-m-d h:i:s');
        $subscription = Subscription::whereHas('limits', function ($q) use ($entityNamespace, $userDriver, $model) {
            //filter limits
            $q->where('entity', $entityNamespace);
        })->whereDate('end_date', '>', $now)->whereDate('start_date', '<=', $now)->where(function ($query) use($userDriver, $model) {
            $query->whereNull('entity')->orWhere(function ($query) use($userDriver, $model) {
                $query->where('entity_id', $model->customer_id ?? $model->user_id ?? auth()->user()->id)->where('entity', "Modules\\User\\Entities\\{$userDriver}\\User");
            });
        })->where('status',1)
          ->orderBy('id')
          ->first();
        if(!empty($subscription)) {
            \Log::info("Subscription id: {$subscription->id} is assigned to related id: {$model->id} from {$entityNamespace}");
            $limitsDisabled = 0;
            $subLimits = $subscription->limits;
            foreach($subLimits as $limit) {
                $validateLimit = true;
                $modelValue = null;
                $limitAttribute = $limit->attribute; //get limit attribute name
                //Validate if limit has attribute
                if (!empty($limitAttribute) && isset($model->$limitAttribute)) {
                    $modelValue = (string)$model->$limitAttribute ?? null;
                    if ($modelValue != $limit->attribute_value) $validateLimit = false;
                }
                if ($validateLimit) {
                    if((int)$limit->quantity > 0) {
                        if ((int)$limit->quantity_used >= (int)$limit->quantity) {
                            $limitsDisabled++;
                        }
                    }
                }
            }
            $subscription->related($entityNamespace)->sync([$model->id], false);
            if($limitsDisabled==count($subLimits)){
                $this->subscription->updateBy($subscription->id, ['status' => 0]);
                \Log::info("Subscription id: {$subscription->id} is disabled due to their subs limits are out of stock");
            }
        }
    }
  }
}
