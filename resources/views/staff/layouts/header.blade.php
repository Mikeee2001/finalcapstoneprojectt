<header class="topbar">

    <button class="burger" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div>
        <strong>{{ Auth::user()->fullname ?? 'staff' }}</strong>
    </div>

</header>
