<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
class ExpertToUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $user;
    public function __construct(User $user, $data)
    {
        $this->data = $data;
        $this->user = $user;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('chat');
        // dd('ddddd');
        // return new PrivateChannel('channel-name');
    }
}
