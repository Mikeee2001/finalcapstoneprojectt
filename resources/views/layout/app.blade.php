<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetCare Dashboard</title>

    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('css/user.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vet-sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pet-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">


<meta name="user-id" content="{{ auth()->id() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user-role" content="{{ auth()->user()->role }}">
@vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f7fb;
        }

        .layout {
            display: flex;
            max-height: 100%;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: linear-gradient(180deg, #1e3a8a, #2563eb);
            color: white;
            padding: 30px;
            transition: 0.3s;
            position: fixed;
            height: 100%;
            overflow: hidden;
        }

        .layout.collapsed .sidebar {
            width: 85px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .menu {
            list-style: none;
        }


        .layout.collapsed .sidebar span {
            display: none;
        }

        .layout.collapsed .sidebar .menu li {
            justify-content: center;
        }

        /* MAIN */
        .main {
            margin-left: 230px;
            flex: 1;
            transition: 0.3s;
        }

        .layout.collapsed .main {
            margin-left: 85px;
        }

        /* HEADER */
        .topbar {
            height: 65px;
            background: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            margin-right: 10px
        }

        .burger {
            border: none;
            background: #2563eb;
            color: white;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        .content {
            padding: 30px;
        }

        @media(max-width:768px) {

            .sidebar {
                left: -260px;
            }

            .layout.collapsed .sidebar {
                left: 0;
                width: 260px;
            }

            .main,
            .layout.collapsed .main {
                margin-left: 0;
            }

            .layout.collapsed .sidebar span {
                display: inline;
            }
        }

    </style>

</head>

<body>

    <div class="layout" id="layout">

        {{-- SIDEBAR --}}
       @if (auth()->user()->role === 'admin')

     @include('admin.layouts.sidebar')

     @elseif(auth()->user()->role === 'user')

        @include('user.layouts.sidebar')

        @elseif(auth()->user()->role === 'vet')

     @include('vet.layouts.sidebar') @endif

        <div class="main">

            {{-- HEADER --}}
            @include('admin.layouts.header')

            {{-- PAGE CONTENT --}}
            <div class="content" id="main-content">
                @yield('content')
            </div>

        </div>
    </div>

    <script src="{{ asset('js/spinner.js') }}"></script>
   <!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JQUERY UI -->
<link rel="stylesheet"
href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<!-- BOOTSTRAP 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DATATABLES -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

<!-- RESPONSIVE -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

{{-- APPOINTMENT CALENDAR --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>

<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function toggleSidebar() {
        document.getElementById('layout')
            .classList.toggle('collapsed');
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        if (typeof window.Echo === 'undefined') {
            console.error('Echo not loaded');
            return;
        }

        // ✅ DEFINE USER ID FIRST (THIS WAS YOUR BUG)
        const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');

        window.Echo.private(`notifications.${userId}`)
            .listen('.notification.created', (e) => {

                // 1. update badge
                const badge = document.getElementById('notificationCount');

                if (badge) {
                    badge.innerText = parseInt(badge.innerText || 0) + 1;
                }

                // 2. add new item
                const body = document.querySelector('.notification-body');

                if (body) {
                    const html = `
                    <div class="notification-item px-3 py-2 border-bottom">
                        <div class="fw-semibold text-dark small">
                            ${e.message.action ?? 'Notification'}
                        </div>
                        <div class="text-muted small mt-1">
                            ${e.message.message ?? ''}
                        </div>
                    </div>
                `;

                    body.insertAdjacentHTML('afterbegin', html);
                }
            });
    });
</script>

</body>
</html>
