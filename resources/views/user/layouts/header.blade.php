<header class="topbar">

    <button onclick="toggleSidebar()" class="burger">

    <i class="fa-solid fa-bars"></i>

</button>

    <div>
        <strong>{{ Auth::user()->fullname ?? 'user' }}</strong>
    </div>

</header>
