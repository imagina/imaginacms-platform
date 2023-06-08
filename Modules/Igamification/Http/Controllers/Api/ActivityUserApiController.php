<?php

namespace Modules\Igamification\Http\Controllers\Api;

use Illuminate\Http\Request;

use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

//Repositories
use Modules\Igamification\Repositories\ActivityRepository;

// Entities
use Modules\Igamification\Entities\Activity;

//Transformer
use Modules\Igamification\Transformers\ActivityTransformer;

class ActivityUserApiController extends BaseApiController
{

    public $activity;

    public function __construct(
        ActivityRepository $activity
    ){
        parent::__construct();
        $this->activity = $activity;
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

            //Filter params
            $paramsFilters = (array)$params->filter;

            //Filter default
            $defaultFilters = ["status" => 1]; // Only Actives

            //Merge filters
            $filters = array_merge($paramsFilters,$defaultFilters);
            $params->filter = (object)($filters);

            // Get activities
            $activities = $this->activity->getItemsBy(json_decode(json_encode($params)));
            //$activities = Activity::with('translations')->where('status',1)->get();

            if(count($activities)==0)
                throw new \Exception(trans('igamification::activities.validation.not actives'), 500);

            //Get User Logged - Middleware Auth
            $userId = \Auth::user()->id;

            //Get activities completed for this User
            $response = [];
            foreach ($activities as &$activity) {
                $user = $activity->users->where('id',$userId)->first();
                $activity = json_decode(json_encode(new ActivityTransformer($activity)));

                $activity->userId = $userId;

                if(!is_null($user))
                    $activity->userCompleted = true;
                else
                    $activity->userCompleted = false;

                // To clean result data
                unset($activity->users);
                $response[] = $activity;
            }

            /*
                Response Collection activities with 2 extra attributes:
                    user_id and user_completed
            */
            $response = ["data" => collect($response)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($models)] : false;

        } catch (\Exception $e) {
            \Log::Error($e);
            $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }


}
