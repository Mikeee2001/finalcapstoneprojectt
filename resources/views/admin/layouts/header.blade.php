<style>
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        background: #fff;
        border-bottom: 1px solid #eee;
    }

    .notification-bell {
        color: #333;
        position: relative;
        padding: 6px;
        border-radius: 10px;
        transition: 0.2s;
    }

    .notification-bell:hover {
        background: #f1f5f9;
    }

    .notification-dropdown {
        width: 320px;
        max-height: 420px;
        overflow: hidden;
        border-radius: 12px;
    }

    .notification-body {
        max-height: 320px;
        overflow-y: auto;
    }

    .notification-item:hover {
        background: #f8f9fa;
        cursor: pointer;
    }

    .notification-footer {
        background: #fff;
    }

    /* NEW */
    .notification-item.unread {
        background: #f8fafc;
    }
</style>

<header class="topbar">

    <button class="burger" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="topbar-right d-flex align-items-center gap-3">

        <!-- NOTIFICATION -->
        <div class="dropdown">

            <a href="#" class="notification-bell position-relative" data-bs-toggle="dropdown">
                <i class="fa-solid fa-bell fs-5"></i>

                <!-- FIX: always show badge -->
                <span id="notificationCount"
                    class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            </a>

            <!-- DROPDOWN -->
            <div class="dropdown-menu dropdown-menu-end notification-dropdown shadow border-0">

                <div class="px-3 py-2 border-bottom">
                    <strong>Notifications</strong>
                    <small class="text-muted float-end">
                        {{ auth()->user()->unreadNotifications->count() }} new
                    </small>
                </div>

                <!-- FIX: ID added -->
                <div class="notification-body" id="notificationBody">

                    @forelse(auth()->user()->notifications->take(10) as $notification)
                        <div class="notification-item px-3 py-2 border-bottom">

                            <div class="d-flex justify-content-between">
                                <div class="fw-semibold text-dark small">
                                    {{ $notification->data['action'] ?? 'Notification' }}
                                </div>

                                <small class="text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <div class="text-muted small mt-1">
                                <strong>{{ $notification->data['user'] ?? 'User' }}</strong>
                                {{ $notification->data['message'] ?? '' }}
                            </div>

                        </div>
                    @empty
                        <div class="text-center p-4 text-muted">
                            <i class="fa-regular fa-bell-slash fs-4 mb-2"></i>
                            <div>No notifications found</div>
                        </div>
                    @endforelse

                </div>

                <div class="text-center p-2 border-top">
                    <a href="{{ route('admin.notifications.index') }}" class="small text-decoration-none">
                        View All Notifications
                    </a>
                </div>

            </div>
        </div>

        <div class="user-info">
            <strong>{{ Auth::user()->fullname ?? 'Admin' }}</strong>
        </div>

    </div>

</header>
