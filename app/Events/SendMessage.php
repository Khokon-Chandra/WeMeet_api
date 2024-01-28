<?php

namespace App\Events;

use App\Http\Resources\V1\ChatResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("message-{$this->data->chatable_id}"),
        ];
    }


    public function broadcastAs(): string
    {
        return 'message-notification';
    }

    public function broadcastWith()
    {
        return [
            'id'          => $this->data->id,
            'user_id'     => $this->data->user_id,
            'chatable_id' => $this->data->chatable_id,
            'message'     => $this->data->message,
            'seen'        => $this->data->seen,
            'date'        => $this->data->created_at->diffForHumans(),    
            'avatar'      => "https://static.thenounproject.com/png/363640-200.png",
            
        ];
    }

}
