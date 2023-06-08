<?php

namespace Modules\Icommercexpay\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class ResponseWasReceived implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;
  
  public $infor;
  
  public function __construct($infor)
  {
    $this->infor = $infor;
  }
  
  public function broadcastAs()
  {
    return 'responseXpay' . $this->infor["orderId"];
  }
  
  public function broadcastWith()
  {
    return [
      'xpayTranId' => $this->infor["xpayTranId"],
      'xpayTranStatus' => $this->infor["xpayTranStatus"],
      'orderId' => $this->infor["orderId"]
    ];
  }
  
  /**
   * Get the channels the event should broadcast on.
   *
   * @return Channel|array
   */
  public function broadcastOn()
  {
    
    return new Channel('global');
  }
  
}
