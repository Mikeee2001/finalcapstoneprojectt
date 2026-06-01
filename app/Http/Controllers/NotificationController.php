<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Notifications\AppointmentStatusNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Mark unread notifications as read
        $user->unreadNotifications->markAsRead();

        // Get all notifications
        $notifications = $user->notifications()
            ->latest()
            ->paginate(5);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointments::findOrFail($id);

        $status = $request->status;

        $appointment->update([
            'status' => $status
        ]);

        // 🔥 Send notification (database + broadcast if your Notification supports it)
        $appointment->user->notify(
            new AppointmentStatusNotification($appointment, $status)
        );

        return response()->json([
            'status' => 1,
            'message' => 'Appointment ' . $status . ' successfully.'
        ]);
    }
}
