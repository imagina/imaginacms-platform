<?php

namespace Modules\Iforms\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Sendmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    public $lead;
    public $subject;
    public $view;

    /**
     * Create a new message instance.
     *
     * @param $lead
     * @param $subject
     * @param $view
     */
    public function __construct($lead, $subject, $view)
    {
        $this->lead=$lead;
        $this->subject=$subject;
        $this->view=$view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view)->subject($this->subject);
    }
}
