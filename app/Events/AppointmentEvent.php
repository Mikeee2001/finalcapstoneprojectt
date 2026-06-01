<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppointmentEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $appointment;
    public $type;
    public $message;

    public function __construct($appointment, $type, $message)
    {
        $this->appointment = $appointment;
        $this->type = $type;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('appointments.user.' . $this->appointment->user_id),
            new PrivateChannel('appointments.admin'),
        ];
    }

    public function broadcastAs()
    {
        return 'appointment.event';
    }

    public function broadcastWith()
    {
        return [
            'appointment_id' => $this->appointment->id,
            'type' => $this->type,
            'message' => $this->message,
            'status' => $this->appointment->status,
        ];
    }
}
