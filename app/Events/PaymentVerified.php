<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentVerified implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function broadcastOn()
    {
        return new Channel('payment.'.$this->order->id);
    }
    
    public function broadcastAs()
    {
        return 'payment.verified';
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'status' => 'verified',
            'redirect_url' => route('download.file', $this->order)
        ];
    }
}