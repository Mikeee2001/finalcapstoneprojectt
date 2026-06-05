@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        <div class="card shadow-sm border-0 rounded-4">

            <!-- HEADER -->
            <div class="card-header bg-primary text-white py-3 rounded-top-4">
                <h5 class="mb-0">
                    <i class="fa-solid fa-bell me-2"></i>
                    Notifications
                </h5>
            </div>

            <!-- BODY -->
            <div class="card-body p-0">

                @forelse($notifications as $notification)
                    <div class="notification-item d-flex align-items-start gap-3 p-3 border-bottom">

                        <!-- ICON -->
                        <div class="notification-icon">
                            <i class="fa-solid fa-circle-info text-primary fs-5"></i>
                        </div>

                        <!-- CONTENT -->
                        <div class="flex-grow-1">

                            <div class="d-flex justify-content-between align-items-center">

                                <div class="notification-title fw-semibold text-dark">
                                    {{ $notification->data['action'] ?? 'Notification' }}
                                </div>

                                <small class="text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>

                            </div>

                            <div class="notification-message text-muted mt-1">
                                <strong>
                                    {{ $notification->data['user'] ?? 'System' }}
                                </strong>

                                <span>
                                    {{ $notification->data['message'] ?? 'No message available.' }}
                                </span>
                            </div>

                        </div>

                    </div>
                @empty

                    <!-- EMPTY STATE -->
                    <div class="text-center py-5">

                        <div class="mb-3">
                            <i class="fa-regular fa-bell-slash fs-1 text-muted"></i>
                        </div>

                        <h6 class="text-muted">No notifications found</h6>
                        <p class="text-muted small mb-0">
                            You're all caught up 🎉
                        </p>

                    </div>
                @endforelse

            </div>

            <!-- PAGINATION -->
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-center">
                    {{ $notifications->links() }}
                </div>
            </div>

        </div>

    </div>
@endsection
