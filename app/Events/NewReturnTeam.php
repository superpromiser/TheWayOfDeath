<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewReturnTeam
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $returnTeam;
    public $id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($returnTeam, $id)
    {
        $this->returnTeam = $returnTeam;
        $this->id = $id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('newReturnTeam.'.$this->id);
    }
}
