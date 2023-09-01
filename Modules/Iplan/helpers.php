<?php

if (! function_exists('iplan_allowLimitPlan')) {
    function iplan_allowLimitPlan($data)
    {
        $options = [
            'limits' => [], //Limits to validate, estructure:
            /*
            {
              "entity"=>"Modules\Iads\Entities\Ad",
              "attribute"=>null,
              "attribute_value"=>null
            }
          */
            'settings' => [
                'requiredsPlanToCreate' => 'iplans::required-plan-to-create',
            ],
        ];
        $response = [
            'status' => true,
            'data' => [],
        ];
        //Merge default data with param
        $options = array_merge($options, $data);
        //Parse to objects
        $options = json_decode(json_encode($options));

        $setting = app('Modules\Setting\Contracts\Setting');
        $requiredPlanToCreate = $setting->get($options->settings->requiredPlanToCreate) ? 1 : 0;
        //If not requireds plan to create, he can.
        if (! $requiredPlanToCreate) {
            return $response;
        }

        //Get limits
        $limits = \Modules\Iplans\Entities\SubscriptionLimit::whereHas('subscription', function ($query) {
            $query->whereDate('end_date', '<', \Carbon\Carbon::now()->format('Y-m-d'));
        })->where('user_id', auth()->user()->id)
          ->groupBy('attribute')
          ->selectRaw('sum(quantity) as quantity,sum(quantity_used) as quantity_used, attribute,attribute_value,entity')
          ->get();

        //Each limits to validate
        foreach ($option->limits as $limitToValidate) {
            //Find limit
            $b = 0;
            foreach ($limits as $limit) {
                if ($limit->entity == $limitToValidate->entity && $limit->attribute == $limitToValidate->attribute && $limit->attribute_value == $limitToValidate->attribute_value) {
                    if ($limit->quantity_used >= $limit->quantity) {
                        $response['status'] = false;

                        return $response;
                    } else {
                        $response['data'][] = (object) [
                            'entity' => $limit->entity,
                            'attribute' => $limit->attribute,
                            'attribute_value' => $limit->attribute_value,
                        ];
                    }
                    $b = 1;
                    break;
                }
            }//each limits
            //if not found limit and required limit to create, return false.
            if (! $b && $requiredPlanToCreate) {
                $response['status'] = false;

                return $response;
            }
        }//limits to validate
        //Call Event to update quantity used : send -> arrayToEvent

        return $response;
    }
}

//Helper to validate if the current user has one or more allowed limit
if (! function_exists('allowedLimits')) {
    function allowedLimits($model)
    {
        $allowedLimits = true; //Defualt response

        //Get entity attributes
        $entityNamespace = get_class($model);
        $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
        $moduleName = $entityNamespaceExploded[1]; //Get module name
        $entityName = $entityNamespaceExploded[3]; //Get entirty name

        //Validate if entity require plan TODO : Obtener desde base de datos
        $requirePlan = true;

        //Validate user limits
        if ($requirePlan) {
            //Get user limits
            $userSubcriptionLimits = \Modules\Iplans\Entities\SubscriptionLimit::whereHas('subscription', function ($query) {
                $query->whereDate('end_date', '<', \Carbon\Carbon::now()->format('Y-m-d'));
            })->where('user_id', auth()->user()->id)
              ->groupBy('attribute')
              ->selectRaw('sum(quantity) as quantity,sum(quantity_used) as quantity_used, attribute,attribute_value,entity')
              ->get();

            dd($userSubcriptionLimits);

            //validate limits
            foreach ($params->limits as $limitToValidate) {
                //Get user subcription limit by entity
                $userSubscriptionLimit = $userSubcriptionLimits->where('entity', $limitToValidate->entity);

                //Condition userSubscriptionLimit by attribute
                if (isset($limitToValidate->attribute) && isset($limitToValidate->attribute_value)) {
                    $userSubscriptionLimit->where('attribute', $limitToValidate->attribute)
                      ->where('attribute_value', $limitToValidate->attribute_value);
                }

                //Get first limit form result
                $userSubscriptionLimit = $userSubscriptionLimit->first();

                //Validate user subscription limit
                if (! $userSubscriptionLimit || ($userSubscriptionLimit->quantity_used >= $userSubscriptionLimit->quantity)) {
                    $allowedLimits = false;
                    break; //end loop
                }
            }
        }

        //Response
        return $allowedLimits;
    }
}
