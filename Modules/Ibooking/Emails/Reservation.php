<?php

namespace Modules\Ibooking\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reservation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reservation;

    public $subject;

    public $view;

    public function __construct($reservation, $subject, $view)
    {
        $this->reservation = $reservation;
        $this->subject = $subject;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view($this->view)
            ->subject($this->subject);
    }
}
