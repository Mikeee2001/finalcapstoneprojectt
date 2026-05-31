<header class="topbar">

    <button class="burger" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="topbar-right">

        <!-- Notification Bell -->
        <div class="notification-dropdown">

            <a href="#" id="notificationBell" class="notification-bell">

                <i class="fa-solid fa-bell"></i>

                <span id="notificationCount"
                    class="notification-badge d-none">
                    0
                </span>

            </a>

        </div>

        <div>
            <strong>{{ Auth::user()->fullname ?? 'Admin' }}</strong>
        </div>

    </div>

</header>
