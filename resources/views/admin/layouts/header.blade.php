<style>
    /* TOPBAR */
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        background: #fff;
        border-bottom: 1px solid #eee;
    }

    /* NOTIFICATION BELL */
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

    /* DROPDOWN */
    .notification-dropdown {
        width: 320px;
        max-height: 420px;
        overflow: hidden;
        border-radius: 12px;
    }

    /* BODY SCROLL */
    .notification-body {
        max-height: 320px;
        overflow-y: auto;
    }

    /* ITEM HOVER */
    .notification-item {
        transition: 0.2s;
    }

    .notification-item:hover {
        background: #f8f9fa;
        cursor: pointer;
    }

    /* FOOTER */
    .notification-footer {
        background: #fff;
    }
</style>
<header class="topbar">

    <!-- LEFT -->
    <button class="burger" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- RIGHT -->
    <div class="topbar-right d-flex align-items-center gap-3">

        <!-- NOTIFICATION -->
        <div class="dropdown">

            <a href="#" class="notification-bell position-relative" data-bs-toggle="dropdown">

                <i class="fa-solid fa-bell fs-5"></i>

                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span id="notificationCount"
                        class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif

            </a>

            <!-- DROPDOWN -->
            <div class="dropdown-menu dropdown-menu-end notification-dropdown shadow border-0">

                <!-- HEADER -->
                <div class="notification-header px-3 py-2 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">

                        <strong class="mb-0">Notifications</strong>

                        <small class="text-muted">
                            {{ auth()->user()->unreadNotifications->count() }} new
                        </small>

                    </div>
                </div>

                <!-- BODY -->
                <div class="notification-body">

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

                <!-- FOOTER -->
                <div class="notification-footer text-center p-2 border-top">
                    <a href="{{ route('admin.notifications.index') }}" class="text-decoration-none small">
                        View All Notifications
                    </a>
                </div>

            </div>
        </div>

        <!-- USER -->
        <div class="user-info">
            <strong>{{ Auth::user()->fullname ?? 'Admin' }}</strong>
        </div>

    </div>

</header>
