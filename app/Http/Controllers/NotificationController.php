<?php

namespace App\Http\Controllers;

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
            ->get();

        return view(
            'notifications.index',
            compact('notifications')
        );
    }
}
