<?php

namespace Modules\Ibooking\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;

//Model Repository
use Modules\Ibooking\Repositories\ReservationRepository;
use Modules\Ibooking\Entities\Reservation;
use Modules\Ibooking\Transformers\ReservationTransformer;

use Illuminate\Http\Request;


class ReservationApiController extends BaseCrudController
{

  public $model;
  public $modelRepository;
  public $reservationService;

  public function __construct(Reservation $model, ReservationRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
    $this->reservationService = app("Modules\Ibooking\Services\ReservationService");
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
      //Get user authenticated
      $userData = \Auth::user();

      //Check if allow public reservations
      if (!setting("ibooking::allowPublicReservation") && !$userData) {
        $status = 500;
        $response = ["messages" => [
          [
            "message" => trans('ibooking::common.noAllowPublicReservations'),
            "type" => "error"
          ]
        ]];
      }else {

        //Get model data
        $modelData = $request->input('attributes') ?? [];
        $params = $this->getParamsRequest($request);
        //Validate Request
        if (isset($this->model->requestValidation['create'])) {
          $this->validateRequestApi(new $this->model->requestValidation['create']($modelData));
        }
        //Create reservations
        $reservation = $this->reservationService->createReservation($modelData);

        /*
        ****Process with payment****
        * 1. Create Checkout Cart
        * 2. Create Order
        * 3. User Pays the order (Event - OrderWasProcessed)
        * 4. Event - ProcessReservationOrder:
        *     - Update Reservation
              - Create Meeting
              - Create Notification
        */
        if (is_module_enabled('Icommerce') && setting('ibooking::reservationWithPayment', null, false)) {

          $checkoutCart = $this->reservationService->createCheckoutCart($modelData, $reservation);

          $response = ["data" => ["redirectTo" => url(trans("icommerce::routes.store.checkout.create"))]];
        } else {

          //Default
          $url = "/ipanel/#/booking/reservations/index";

          //If it's iadmin take that url
          if(isset($params->setting) && isset($params->setting->appMode)) {
            $url = "/".$params->setting->appMode."/#/booking/reservations/index";
          }
          //Response
          $response = ["data" => [
            "redirectTo" => $userData ? url($url) : null,
            "reservation" => new ReservationTransformer($reservation)
          ]];
        }


        \DB::commit(); //Commit to Data Base
      }
    } catch (\Exception $e) {
      \Log::error('[error-ibooking] ReservationApiController|Create|Message: ' . $e->getMessage() . ' | FILE: ' . $e->getFile() . ' | LINE: ' . $e->getLine());
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
}
