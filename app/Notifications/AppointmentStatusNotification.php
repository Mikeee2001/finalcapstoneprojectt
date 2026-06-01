<?php

namespace App\Notifications;


use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AppointmentStatusNotification extends Notification
{
    protected $appointment;
    protected $status;

    public function __construct($appointment, $status)
    {
        $this->appointment = $appointment;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database', 'mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        switch ($this->status) {

            case 'approved':
                $subject = 'Appointment Approved';
                $message = 'Your appointment has been approved.';
                break;

            case 'rescheduled':
                $subject = 'Appointment Rescheduled';
                $message = 'Your appointment has been rescheduled.';
                break;

            case 'cancelled':
                $subject = 'Appointment Cancelled';
                $message = 'Your appointment has been cancelled.';
                break;

            default:
                $subject = 'Appointment Update';
                $message = 'Your appointment status has been updated.';
        }

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $notifiable->fullname)
            ->line($message)
            ->line('Status: ' . ucfirst($this->status));
    }

    public function toArray($notifiable)
    {
        return [
            'action' => ucfirst($this->status) . ' Appointment',
            'message' => match ($this->status) {
                'approved' => 'Your appointment has been approved.',
                'rescheduled' => 'Your appointment has been rescheduled.',
                'cancelled' => 'Your appointment has been cancelled.',
                default => 'Your appointment status has been updated.',
            },
            'user' => $notifiable->fullname,
            'appointment_id' => $this->appointment->id,
            'status' => $this->status,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'action' => ucfirst($this->status) . ' Appointment',
            'message' => match ($this->status) {
                'approved' => 'Your appointment has been approved.',
                'rescheduled' => 'Your appointment has been rescheduled.',
                'cancelled' => 'Your appointment has been cancelled.',
                default => 'Your appointment status has been updated.',
            },
            'user' => $notifiable->fullname,
            'appointment_id' => $this->appointment->id,
            'status' => $this->status,
        ]);
    }
}
