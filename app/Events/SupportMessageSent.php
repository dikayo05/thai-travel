<?php

namespace App\Events;

use App\Models\SupportMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupportMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public SupportMessage $message;

    public function __construct(SupportMessage $message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('support.chat.' . $this->message->conversation_id)];
    }

    public function broadcastAs(): string
    {
        return 'support.message';
    }

    public function broadcastWith(): array
    {
        $this->message->loadMissing('user');

        return [
            'message' => [
                'id' => $this->message->id,
                'body' => $this->message->body,
                'created_at' => $this->message->created_at?->toIso8601String(),
                'user' => [
                    'id' => $this->message->user?->id,
                    'name' => $this->message->user?->name,
                    'is_admin' => $this->message->user?->hasRole('admin') ?? false,
                ],
            ],
        ];
    }
}
