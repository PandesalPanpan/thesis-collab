<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FingerPrint implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $ip;
    public $template;
    public function __construct($data, $ip, $template)
    {
        $this->data = base64_encode($data);
        $this->ip = $ip;
        $this->template = $template;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('finger-print'),
        ];
    }
}
