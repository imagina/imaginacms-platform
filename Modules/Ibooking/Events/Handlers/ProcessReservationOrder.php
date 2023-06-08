<?php

namespace Modules\Ibooking\Events\Handlers;

use Modules\Ibooking\Repositories\ReservationRepository;
use Modules\Ibooking\Events\ReservationWasCreated;

class ProcessReservationOrder
{

    public $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
      $this->reservationRepository = $reservationRepository; 
    }

    public function handle($event)
    {

        \Log::info('Ibooking: Events|Handlers|ProcessReservationOrder');

        $order = $event->order;
        //Order is Proccesed
        if($order->status_id==13){

            // Get Reservation Id From option in Order Item
            $reservationId = null;
            foreach($order->orderItems as $item){
                if(isset($item->options->reservationId))
                    $reservationId = $item->options->reservationId;
                break;
            }

            // Update Status Reservation
            // With the trait WithItems update Item Status
            // With the trait WithMeeting create de meeting to the Item
            if(!is_null($reservationId)){
                $reservation = $this->reservationRepository->updateBy($reservationId, [
                "status" => 1 //Approved
                ],null);
            }


        }// end If


    }// If handle



}
