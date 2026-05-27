<aside class="sidebar">

    <!-- LOGO -->
    <div class="logo">
        <i class="fa-solid fa-paw"></i>
        <span>VetCare</span>
    </div>

    <!-- MENU -->
    <ul class="menu">

        <!-- DASHBOARD -->
        <li>
            <a href="{{ route('user.dashboard') }}"
               class="menu-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">

                <i class="fa-solid fa-gauge"></i>
                <span>Dashboard</span>

            </a>
        </li>

        <!-- APPOINTMENTS -->
        <li>
            <a href="#"
               class="menu-link #">

                <i class="fa-solid fa-calendar-check"></i>
                <span>Appointments</span>

            </a>
        </li>

        <!-- PETS -->
        <li>
            <a href="#"
               class="menu-link #">

                <i class="fa-solid fa-paw"></i>
                <span>My Pets</span>

            </a>
        </li>

        <!-- MEDICAL RECORDS -->
        <li>
            <a href="#"
               class="menu-link #">

                <i class="fa-solid fa-file-medical"></i>
                <span>Medical Records</span>

            </a>
        </li>

        <!-- PAYMENTS -->
        <li>
            <a href="#"
               class="menu-link #">

                <i class="fa-solid fa-credit-card"></i>
                <span>Payments</span>

            </a>
        </li>

        <!-- SETTINGS -->
        <li>
            <a href="{{ route('user.settings') }}"
               class="menu-link {{ request()->routeIs('user.settings') ? 'active' : '' }}">

                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>

            </a>
        </li>

        <!-- LOGOUT -->
        <li class="logout-item">

            <a href="#"
               class="menu-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>

            </a>

            <form id="logout-form"
                  action="{{ route('logout') }}"
                  method="POST"
                  style="display:none;">

                @csrf

            </form>

        </li>

    </ul>

</aside>
