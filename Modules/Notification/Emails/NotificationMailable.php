<?php
namespace Modules\Notification\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationMailable extends Mailable implements ShouldQueue
{
  use Queueable, SerializesModels;
  
  public $subject;
  public $view;
  public $fromAddress;
  public $fromName;
  public $data;
  /**
   * Create a new message instance.
   *
   * @param $user
   * @param $auction
   * @param $subject
   * @param $view
   */
  public function __construct( $data, $subject, $view, $fromAddress = null, $fromName = null)
  {
    $this->subject = $subject;
    $this->view = $view;
    $this->fromAddress = $fromAddress;
    $this->fromName = $fromName;
    $this->data = $data;
  }
  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    try {
    return $this->from($this->fromAddress ?? env('MAIL_FROM_ADDRESS'), $this->fromName ?? env('MAIL_FROM_NAME'))
      ->view($this->view)
      ->subject($this->subject);
    } catch (\Exception $e) {
      \Log::error("Notification Error | Sending EMAIL : " . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine() . $e->getTraceAsString());
    }
  }
}