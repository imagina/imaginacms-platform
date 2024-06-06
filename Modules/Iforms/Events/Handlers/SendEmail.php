<?php

namespace Modules\Iforms\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\Iforms\Emails\Sendmail;
use Modules\Iforms\Events\LeadWasCreated;

class SendEmail
{

    private $mail;
    private $setting;

    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
        $this->setting = app('Modules\Setting\Contracts\Setting');
    }

    public function handle(LeadWasCreated $event)
    {

        $leads = $event->entity;
        $form=$event->data['form'];
        $reply=$event->data['reply'];
        $sender = $this->setting->get('core::site-name');
        $subject = $form->title . " " . trans('iforms::forms.messages.from') . " " . $sender;
        $view = ['iforms::frontend.emails.form','iforms::frontend.emails.textform'];

        $formEmails = !empty($this->setting->get('iforms::form-emails'))?$this->setting->get('iforms::form-emails'):env('MAIL_FROM_ADDRESS');
        $emails = explode(',', $formEmails);

        if (isset($form->destination_email) && !empty($form->destination_email)) {
            array_merge($emails, $form->destination_email ?? []);
        }

        $this->mail->to($emails)->send(new Sendmail(['lead'=>$leads,'form'=>$form], $subject, $view),function ($m) use($reply) {
            $m->replyTo($reply->to, $reply->toName);
        });

    }
}
