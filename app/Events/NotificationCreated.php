<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;
    public $userId;
    public $role;

    public function __construct($userId, $role, $message)
    {
        $this->userId = $userId;
        $this->role = $role;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('notifications.' . $this->userId),
            new PrivateChannel('notifications.role.' . $this->role),
        ];
    }

    public function broadcastAs()
    {
        return 'notification.created';
    }

    public function broadcastWith()
    {
        return $this->message;
    }
}
