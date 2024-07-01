<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FingerPrintReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $id;
    public $ip;

    public function __construct($id, $ip)
    {
        $this->id = $id;
        $this->ip = $ip;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('finger-print-received'),
        ];
    }
}
