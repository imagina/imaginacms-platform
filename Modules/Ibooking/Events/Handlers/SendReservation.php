<?php

namespace Modules\Ibooking\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\User\Entities\Sentinel\User;
use Modules\Notification\Services\Notification;
use Modules\Iforms\Entities\Field;

class SendReservation
{

  /**
   * @var Mailer
   */
  private $mail;
  private $setting;
  private $notification;
  public $notificationService;

  public function __construct(Mailer $mail, Notification $notification)
  {
    $this->mail = $mail;
    $this->setting = app('Modules\Setting\Contracts\Setting');
    $this->notification = $notification;
    $this->notificationService = app("Modules\Notification\Services\Inotification");

  }

  public function handle($event)
  {

    try {

      $reservation = $event->reservation;
      $params = $event->params;

      $subject = trans('ibooking::reservations.messages.purchase reservation') . " #" . $reservation->id;

      //Emails from setting form-emails
      $emailTo = json_decode(setting("ibooking::formEmails", null, "[]"));
      if (empty($emailTo)) //validate if its a string separately by commas
        $emailTo = explode(',', setting('ibooking::formEmails'));

      //Emails from users selected in the setting usersToNotify
      $usersToNotify = json_decode(setting("ibooking::usersToNotify", null, "[]"));
      $users = User::whereIn("id", $usersToNotify)->get();
      $emailTo = array_merge($emailTo, $users->pluck('email')->toArray());
      $broadcastTo = $users->pluck('id')->toArray();

      //Get emails from the services form
      foreach ($reservation->items as $item) {
        $service = $item->service;//Get item service
        $serviceForm = $service ? $service->form : null; //get form service
        //Get field from form to notify
        if ($serviceForm && isset($serviceForm->options->replyTo)) {
          $field = Field::find($serviceForm->options->replyTo);
          //Get field value and add it to emailTo
          if ($field) {
            $itemFields = $item->formatFillableToModel($item->fields);
            $itemFieldValue = $itemFields[$field->name] ?? null;
            //Validate if has email format
            if ($itemFieldValue && filter_var($itemFieldValue, FILTER_VALIDATE_EMAIL))
              $emailTo[] = $itemFieldValue;
          }
        }
      }

      //Extra params from event
      if(!is_null($params)){
        if(isset($params['broadcastTo'])){
           $broadcastTo = array_merge($broadcastTo,$params['broadcastTo']);
           //\Log::info("Ibooking: Events|Handler|SendReservation|broadcastTo: ".json_encode($broadcastTo));
        }
      }

      if(!empty($reservation->customer_id)){
        $emailReservation = $reservation->customer->email;
        array_push($emailTo, $emailReservation);
      }

      // Data Notification
      $to["email"] = $emailTo;
      $to["broadcast"] = $broadcastTo;

      $push = [
        "title" => trans("ibooking::reservations.title.confirmation reservation"),
        "message" => $subject,
        "link" => url('/ipanel/#/booking/reservations/index'),
        "content" => "ibooking::emails.reservation",
        "view" => "ibooking::emails.Reservation",
        "frontEvent" => [
          "name" => "ibooking.new.reservation",
        ],
        "setting" => ["saveInDatabase" => 1],
        "reservation" => $reservation
      ];

      //Send Notification
      $this->notificationService->to($to)->push($push);


    } catch (\Exception $e) {

      \Log::error('Ibooking: Events|Handler|SendReservation|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());
    }


  }


}
