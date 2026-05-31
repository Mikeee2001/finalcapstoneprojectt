<aside class="sidebar">

    <!-- LOGO -->
    <div class="logo">
        <i class="fa-solid fa-paw"></i>
        <span>VetCare</span>
    </div>

    <!-- MENU -->
    <ul class="menu">

        <!-- MAIN MENU -->
        <li class="menu-link menu-title">MAIN MENU</li>

        <li>
            <a href="{{ route('user.dashboard') }}"
                class="menu-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- <!-- APPOINTMENTS -->
        <li class="menu-title">APPOINTMENTS</li> --}}

        <li>
            <a href="{{ route('user.add.appointment') }}"
                class="menu-link {{ request()->routeIs('user.add.appointment') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-plus"></i>
                <span>Book Appointment</span>
            </a>
        </li>

        <li>
            <a href=""
                class="menu-link ">
                <i class="fa-solid fa-calendar-check"></i>
                <span>My Appointments</span>
            </a>
        </li>

        {{-- <!-- MY PETS -->
        <li class="menu-title">MY PETS</li> --}}

        <li>
            <a href="{{ route('user.pets') }}" class="menu-link {{ request()->routeIs('user.pets*') ? 'active' : '' }}">
                <i class="fa-solid fa-paw"></i>
                <span>My Pets</span>
            </a>
        </li>

        <li>
            <a href=""
                class="menu-link ">
                <i class="fa-solid fa-syringe"></i>
                <span>Vaccinations</span>
            </a>
        </li>

        <li>
            <a href="#"
                class="menu-link ">
                <i class="fa-solid fa-file-medical"></i>
                <span>Medical History</span>
            </a>
        </li>

        {{-- <!-- BILLING -->
        <li class="menu-title">BILLING</li> --}}

        <li>
            <a href="#"
                class="menu-link">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Invoices</span>
            </a>
        </li>

        <li>
            <a href="#"
                class="menu-link ">
                <i class="fa-solid fa-credit-card"></i>
                <span>Payments</span>
            </a>
        </li>

        <li>
            <a href="{{ route('user.settings') }}"
                class="menu-link {{ request()->routeIs('user.settings') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
        </li>

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
