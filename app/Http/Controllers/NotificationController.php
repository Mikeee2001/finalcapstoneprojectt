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
        $request->validate([
            'status' => 'required|in:approved,completed,cancelled'
        ]);

        $appointment = Appointments::findOrFail($id);

        $appointment->update([
            'status' => $request->status
        ]);

        $user = $appointment->pets->user ?? null;

        if ($user) {

            // 1. Database notification
            $user->notify(
                new AppointmentStatusNotification($appointment, $request->status)
            );

            // 2. Real-time event broadcast (THIS IS WHAT YOU NEED)
            event(new \App\Events\NotificationCreated(
                $user->id,
                $user->role,
                [
                    'action' => 'Appointment ' . ucfirst($request->status),
                    'message' => 'Your appointment was ' . $request->status,
                    'appointment_id' => $appointment->id
                ]
            ));
        }

        return response()->json([
            'status' => 1,
            'message' => 'Appointment ' . $request->status . ' successfully.'
        ]);
    }

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'sometimes|date',
            'appointment_time' => 'sometimes'
        ]);

        $appointment = Appointments::findOrFail($id);

        $data = [];

        if ($request->filled('appointment_date')) {
            $data['appointment_date'] = $request->appointment_date;
        }

        if ($request->filled('appointment_time')) {
            $data['appointment_time'] = $request->appointment_time;
        }

        // only change status if something is actually updated
        if (!empty($data)) {
            $data['status'] = 'rescheduled';
        }

        $appointment->update($data);

        $user = $appointment->pets->user ?? null;

        if ($user) {
            $user->notify(
                new AppointmentStatusNotification($appointment, 'rescheduled')
            );
        }

        return response()->json([
            'status' => 1,
            'message' => 'Appointment rescheduled successfully!'
        ]);
    }

}
