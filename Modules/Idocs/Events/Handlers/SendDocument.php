<?php

namespace Modules\Idocs\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\Idocs\Events\DocumentWasCreated;
use Modules\Idocs\Emails\Sendmail;
use Modules\Setting\Contracts\Setting;

class SendDocument
{

    private $mail;
    private $setting;

    public function __construct(Mailer $mail, Setting $setting)
    {
        $this->mail = $mail;
        $this->setting = $setting;
    }

    public function handle(DocumentWasCreated $event)
    {
      try {
        if (config('asgard.idocs.config.fields.documents.key') || config('asgard.idocs.config.fields.documents.users')) {
      
          $document = $event->document;
          $sender = $this->setting->get('core::site-name');
          $subject = trans('idocs::documents.messages.subject', ['document' => $document->title]) . " " . $sender;
          $view = ['idocs::frontend.emails.form', 'idocs::frontend.emails.textform'];
      
          if (isset($document->email)) {
            $email = $document->email;
            $mail = $this->mail->to($email)->send(new Sendmail($document, $subject, $view));
        
          } else if (config('asgard.idocs.config.fields.documents.users') && count($document->users)) {
            foreach ($document->users as $user) {
              $email = $user->emmail;
              $this->mail->to($email)->send(new Sendmail(['document' => $document], $subject, $view));
            }
        
          }
        }
      } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return $e;
      }
    }
}