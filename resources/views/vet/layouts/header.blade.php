<header class="topbar">

    <button class="burger" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="topbar-right">

        <a href="{{ route('vet.notifications.index') }}" class="position-relative notification-bell">

            <i class="fa-solid fa-bell"></i>

            @if (auth()->user()->unreadNotifications->count() > 0)
                <span id="notificationCount" class="badge bg-danger position-absolute top-0 start-100 translate-middle">

                    {{ auth()->user()->unreadNotifications->count() }}

                </span>
            @endif

        </a>

        <strong>{{ Auth::user()->fullname ?? 'Vet' }}</strong>

    </div>

</header>
