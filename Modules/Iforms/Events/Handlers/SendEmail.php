<?php

namespace Modules\Iforms\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\Iforms\Emails\Sendmail;
use Modules\User\Entities\Sentinel\User;
use Modules\Iforms\Events\LeadWasCreated;

class SendEmail
{
  
  private $mail;
  private $setting;
  public $notificationService;
  
  public function __construct(Mailer $mail)
  {
    $this->mail = $mail;
    $this->setting = app('Modules\Setting\Contracts\Setting');
    $this->notificationService = app("Modules\Notification\Services\Inotification");
  }
  
  public function handle(LeadWasCreated $event)
  {
    
    $lead = $event->entity;
    $form = $event->data['form'];
    $reply = $event->data['reply'];

    $sender = $this->setting->get('core::site-name');
  
    //Emails from setting iforms::from-email
    $emailsTo = setting("iforms::from-email");
    
    $formEmails = json_decode(setting("iforms::form-emails", null, "[]"));
    //Emails from setting form-emails
    $emailsTo = array_merge(!empty($emailsTo) ? [$emailsTo] : [], !empty($formEmails) ? $formEmails : []);

    if (empty($emailsTo)) //validate if its a string separately by commas
      $emailsTo = explode(',', setting('icommerce::form-emails'));
  
    //Emails from users selected in the setting usersToNotify
    $usersToNotity = json_decode(setting("iforms::usersToNotify", null, "[]"));
    $users = User::whereIn("id", $usersToNotity)->get();
    $emailsTo = array_merge($emailsTo, $users->pluck('email')->toArray());
    
    //adding .env MAIL_FROM_ADDRESS
    $emailsTo = array_merge($emailsTo, [env('MAIL_FROM_ADDRESS')]);
    
    //adding destination_email in the form
    if (isset($form->destination_email) && !empty($form->destination_email)) {
      $emailsTo = array_merge($emailsTo, $form->destination_email ?? []);
    }
  
    \Log::info("[Iforms::sending lead email]::to:". join(",",$emailsTo));
    \Log::info("[Iforms::sending lead broadcast and push]::to:". join(",",$users->pluck('id')->toArray()));
  
    //send notification by email, broadcast and push -- by default only send by email
    $this->notificationService->to([
      "email" => $emailsTo,
      "broadcast" => $users->pluck('id')->toArray(),
      "push" => $users->pluck('id')->toArray(),
    ])->push(
      [
        "title" => trans("iforms::forms.title.newLead",["formTitle" => $form->title]),
        "message" => "",
        "icon_class" => "fas fa-clipboard-list",
        "link" => env("APP_URL")."/iadmin/#/form/lead/?viewLead=$lead->id",
        "content" => "iforms::emails.textform",
        "replyTo" => $reply,
        "setting" => [
          "saveInDatabase" => 1 // now, the notifications with type broadcast need to be save in database to really send the notification
        ],
        "lead" => $lead,
        "form" => $form
      ]
    );
    
  }
}
