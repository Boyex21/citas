<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Doctor;

class UserToExpert implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $doctor;
    public $data;

    public function __construct(Doctor $doctor, $data)
    {
        $this->doctor = $doctor;
        $this->data = $data;
    }


        public function broadcastWith () {
            return $this->data;
        }


        public function broadcastOn()
        {
            // return new PrivateChannel('App.Models.Doctor.'.$this->doctor->id);

            return new PrivateChannel('chat');
        }
}
