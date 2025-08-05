<?php

namespace App\Events;

use App\Models\TodoItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TodoItemCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;

    public function __construct(TodoItem $item)
    {
        $this->item = $item->load('user');
    }

    public function broadcastOn()
    {
        return new Channel('todo.' . $this->item->todo_id);
    }

    public function broadcastWith()
    {
        return [
            'item' => $this->item,
            'message' => 'New todo item created'
        ];
    }
}
