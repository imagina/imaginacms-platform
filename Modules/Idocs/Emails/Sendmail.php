<?php

namespace Modules\Idocs\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Sendmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $document;

    public $subject;

    public $view;

    /**
     * Create a new message instance.
     */
    public function __construct($document, $subject, $view)
    {
        $this->document = $document;
        $this->subject = $subject;
        $this->view = $view;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view($this->view)->subject($this->subject);
    }
}
