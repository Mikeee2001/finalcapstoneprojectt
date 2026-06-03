<aside class="sidebar">

    <div class="logo">
        <i class="fa-solid fa-paw"></i>
        <span menu-title>VetCare</span>
    </div>

    <ul class="menu">

        <!-- MAIN MENU -->
        <li class="menu-link menu-title">MAIN MENU</li>

        <!-- DASHBOARD -->
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                <i class="fa-solid fa-gauge"></i>
                <span>Dashboard</span>

            </a>
        </li>

        <!-- APPOINTMENTS -->
        <li>
            <a href="{{ route('admin.all.appointments.fetch') }}"
            class="menu-link {{ request()->routeIs('admin.all.appointments.fetch') ? 'active' : '' }}">

                <i class="fa-solid fa-calendar-check"></i>
                <span>Appointments</span>

            </a>
        </li>

        <!-- USERS -->
        <li>
            <a href="{{ route('admin.users') }}"
                class="menu-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">

                <i class="fa-solid fa-users"></i>
                <span>Users</span>

            </a>
        </li>

        <!-- PETS -->
        <li>
            <a href="#" class="menu-link">

                <i class="fa-solid fa-paw"></i>
                <span>Pets</span>

            </a>
        </li>

        <!-- SERVICE -->
        <li>
            <a href="{{ route('admin.services') }}" class="menu-link">
                <i class="fa-solid fa-kit-medical"></i>
                <span>Services</span>
            </a>
        </li>

        <!-- INVENTORY -->
        <li>
            <a href="#" class="menu-link">
                <i class="fa-solid fa-boxes-stacked"></i>
                <span>Inventory</span>
            </a>
        </li>

        <!-- SETTINGS -->
        <li>
            <a href="{{ route('admin.settings') }}"
                class="menu-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">

                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>

            </a>
        </li>

        <!-- LOGOUT -->
        <li class="logout-item">
            <a href="#" class="menu-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>

            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </li>

    </ul>

</aside>
