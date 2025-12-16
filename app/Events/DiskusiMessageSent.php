<?php

namespace App\Events;

use App\Models\Diskusi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiskusiMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $diskusi;

    /**
     * Create a new event instance.
     */
    public function __construct(Diskusi $diskusi)
    {
        $this->diskusi = $diskusi->load('user:id,name,role');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    // public function broadcastOn(): array
    // {
    //     return new Channel('diskusi.' . $this->diskusi->id_mata_pelajaran);
    // }

    public function broadcastOn()
    {
        return [
            new Channel('diskusi.' . $this->diskusi->id_mata_pelajaran)
        ];
    }


    public function broadcastAs()
    {
        return 'diskusi.message';
    }
}
