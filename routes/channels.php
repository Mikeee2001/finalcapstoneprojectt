<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('notifications.role.{role}', function ($user, $role) {
    return $user->role === $role;
});

/*
|------------------------------------
| ADMIN (receives ALL appointment activity)
|------------------------------------
*/
Broadcast::channel('appointments.admin', function ($user) {
    return $user->role === 'admin';
});
