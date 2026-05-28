<aside class="sidebar">

    <!-- LOGO -->
    <div class="logo">

        <i class="fa-solid fa-user-doctor"></i>

        <span>VetCare</span>

    </div>

    <!-- MENU -->
    <ul class="menu">

        <!-- DASHBOARD -->
        <li>

            <a href="{{ route('vet.dashboard') }}"
               class="menu-link {{ request()->routeIs('vet.dashboard') ? 'active' : '' }}">

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

        <!-- PATIENT PETS -->
        <li>

            <a href="#"
               class="menu-link">

                <i class="fa-solid fa-paw"></i>

                <span>Patient Pets</span>

            </a>

        </li>

        <!-- MEDICAL RECORDS -->
        <li>

            <a href="#"
               class="menu-link">

                <i class="fa-solid fa-file-medical"></i>

                <span>Medical Records</span>

            </a>

        </li>

        <!-- PRESCRIPTIONS -->
        <li>

            <a href="#"
               class="menu-link">

                <i class="fa-solid fa-prescription-bottle-medical"></i>

                <span>Prescriptions</span>

            </a>

        </li>

        <!-- SETTINGS -->
        <li>
            <a href="{{ route('vet.settings') }}"
                class="menu-link {{ request()->routeIs('vet.settings') ? 'active' : '' }}">

                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>

            </a>
        </li>

        <!-- LOGOUT -->
        <li class="logout-item">

            <a href="#"
               class="menu-link"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">

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
