@extends('layout.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>

    <style>
        .stat-card {
            background: white;
            border-radius: 18px;
            padding: 25px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
        }

        .stat-card i {
            position: absolute;
            right: 20px;
            bottom: 10px;
            font-size: 60px;
            opacity: .15;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }

        .stat-card span {
            color: #64748b;
        }

        .stat-blue {
            border-left: 5px solid #2563eb;
        }

        .stat-yellow {
            border-left: 5px solid #f59e0b;
        }

        .stat-green {
            border-left: 5px solid #16a34a;
        }

        .stat-teal {
            border-left: 5px solid #14b8a6;
        }

        .search-box {
            height: 50px;
            border-radius: 12px;
        }

        .table td {
            padding: 18px;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .dropdown {
            position: static;
        }

        .dropdown-menu {
            position: absolute;
            z-index: 1055;
        }

        .stat-col {
            flex: 0 0 20%;
            max-width: 20%;
        }

        @media (max-width: 768px) {
            .stats-wrapper {
                flex-wrap: wrap;
            }

            .stats-wrapper .stat-card {
                flex: 1 1 45%;
            }
        }

        @media (max-width: 480px) {
            .stats-wrapper .stat-card {
                flex: 1 1 100%;
            }
        }

        .stats-wrapper {
            display: flex;
            gap: 15px;
            justify-content: space-between;
            flex-wrap: nowrap;
        }

        .stats-wrapper .stat-card {
            flex: 1;
            /* equal width */
            min-width: 0;
        }
    </style>
    <div class="container-fluid appointment-container py-4">



        <!-- TOGGLE BUTTONS (KEPT SAFE) -->
        <div class="mb-3 text-end">
            <button id="showTable" class="btn btn-primary btn-sm">Table View</button>
            <button id="showCalendar" class="btn btn-success btn-sm">Calendar View</button>
        </div>

        <!-- ================= TABLE VIEW  ================= -->

        <!-- TOP STATS -->
        <div id="tableView">
            <div class="stats-wrapper">

                <div class="stat-card stat-blue">
                    <i class="fa-solid fa-calendar-check"></i>
                    <h3>{{ $totalCount }}</h3>
                    <span>Total</span>
                </div>

                <div class="stat-card stat-yellow">
                    <i class="fa-solid fa-clock"></i>
                    <h3>{{ $pendingCount }}</h3>
                    <span>Pending</span>
                </div>

                <div class="stat-card stat-green">
                    <i class="fa-solid fa-xmark"></i>
                    <h3>{{ $cancelledCount }}</h3>
                    <span>Cancelled</span>
                </div>

                <div class="stat-card stat-blue">
                    <i class="fa-solid fa-circle-check"></i>
                    <h3>{{ $approvedCount }}</h3>
                    <span>Approved</span>
                </div>

                <div class="stat-card stat-teal">
                    <i class="fa-solid fa-stethoscope"></i>
                    <h3>{{ $completedCount }}</h3>
                    <span>Completed</span>
                </div>
            </div>
        </div>

        <!-- SEARCH + FILTER -->
        <form method="GET" action="{{ url('/admin/appointments') }}">
            <div class="row mb-4 mt-3">

                <div class="col-md-8">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                        class="form-control search-box" placeholder="Search pet, owner, service...">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select" id="statusFilter">
                        <option value="">All Status</option>

                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                            Approved
                        </option>

                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                        <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>
                            Rescheduled
                        </option>
                    </select>
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>

            </div>
        </form>

        <!-- TABLE CARD -->
        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="fa-solid fa-calendar-check text-primary"></i>
                    Appointment Management
                </h5>
            </div>

            <div class="table-responsive">

                <div id="appointmentsTableContainer">

                    <table class="table align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Pet</th>
                                <th>Service</th>
                                <th>Date & Time</th>
                                <th>Veterinarian</th>
                                <th>Status</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="appointmentsTbody">

                            @forelse ($appointments as $appointment)
                                @php
                                    $pet = $appointment->pets;

                                    $petImage =
                                        $pet && $pet->pet_image
                                            ? asset('pet_images/' . $pet->pet_image)
                                            : asset('images/default-pet.png');

                                    $vet = $appointment->vets;

                                    $vetImage =
                                        $vet && $vet->image
                                            ? asset('storage/' . $vet->image)
                                            : asset('images/default-vet.png');
                                @endphp

                                <tr>

                                    {{-- PET --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $petImage }}" class="rounded-circle border" width="45"
                                                height="45" style="object-fit: cover;">

                                            <div>
                                                <div class="fw-bold">
                                                    {{ $pet->pet_name ?? 'No Pet' }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $pet->user->fullname ?? 'No Owner' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- SERVICE --}}
                                    <td>
                                        {{ $appointment->service->service_name ?? 'No Service' }}
                                    </td>

                                    {{-- DATE --}}
                                    <td>
                                        <div>
                                            {{ Carbon\Carbon::parse($appointment->appointment_date ?? $appointment->requested_date)->format('M d, Y') }}
                                        </div>

                                        <small class="text-muted">
                                            {{ Carbon\Carbon::parse($appointment->appointment_time ?? $appointment->requested_time)->format('h:i A') }}
                                        </small>
                                    </td>

                                    {{-- VET --}}
                                    <td>
                                        @if ($vet)
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $vetImage }}" class="rounded-circle border" width="40"
                                                    height="40" style="object-fit: cover;">

                                                <div>
                                                    <div class="fw-semibold">
                                                        Dr. {{ $vet->user->fullname ?? 'N/A' }}
                                                    </div>
                                                    <small class="text-muted">Veterinarian</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">Not Assigned</span>
                                        @endif
                                    </td>

                                    <td class="status-cell">
                                        <span class="badge"
                                            style="
                                                    background-color: {{ $appointment->status_color }};
                                                    color:white;
                                                    padding:8px 12px;
                                                    border-radius:20px;
                                                ">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-light border" data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">

                                                @if ($appointment->status == 'pending')
                                                    <li>
                                                        <a class="dropdown-item update-status"
                                                            data-id="{{ $appointment->id }}"
                                                            data-status="approved">Approve</a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item update-status"
                                                            data-id="{{ $appointment->id }}"
                                                            data-status="cancelled">Cancel</a>
                                                    </li>
                                                @elseif($appointment->status == 'approved')
                                                    <li>
                                                        <a class="dropdown-item update-status"
                                                            data-id="{{ $appointment->id }}"
                                                            data-status="completed">Complete</a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item reschedule-btn"
                                                            data-id="{{ $appointment->id }}">Reschedule</a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item assign-vet-btn"
                                                            data-id="{{ $appointment->id }}">Assign Vet</a>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr id="serverEmptyRow">
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fa-solid fa-calendar-xmark fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">No appointments found</h6>
                                    </td>
                                </tr>
                            @endforelse

                            {{-- JS EMPTY ROW --}}
                            <tr id="noResultsRow" style="display:none;">
                                <td colspan="6" class="text-center py-5">
                                    <i class="fa-solid fa-search fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">No matching results</h6>
                                </td>
                            </tr>

                        </tbody>


                    </table>

                </div>

                <div id="paginationLinks" class="mt-3">
                    {{ $appointments->appends(request()->query())->links() }}
                </div>

            </div>

        </div>
    </div>

    {{-- RESCHEDULE MODAL (ADDED ONLY - NO DELETION) --}}
    <div class="modal fade" id="rescheduleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        Reschedule Appointment
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="reschedule_id">

                    <div class="mb-3">
                        <label class="form-label">
                            New Date
                        </label>

                        <input type="date" id="appointment_date" class="form-control" min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            New Time
                        </label>

                        <input type="time" id="appointment_time" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="button" class="btn btn-warning" id="saveReschedule">
                        Save Changes
                    </button>

                </div>

            </div>
        </div>
    </div>


    <!-- ================= CALENDAR VIEW ================= -->
    <div id="calendarView" style="display:none;">
        <div class="card mt-3 shadow-sm">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>



    <!-- ================= YOUR EXISTING MODALS ================= -->
    <div class="modal fade" id="assignVetModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Assign Veterinarian</h5>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="appointment_id">

                    <select id="vet_id" class="form-select">
                        <option value="">Select Veterinarian</option>

                        @foreach ($vets as $vet)
                            <option value="{{ $vet->id }}">
                                {{ $vet->user->fullname }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="assignVetBtn">
                        Assign
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= YOUR EXISTING SCRIPTS ================= -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script>
        // PAGINATION SCRIPT
        $(document).on('click', '#paginationLinks a', function(e) {

            e.preventDefault();

            $.get($(this).attr('href'), function(data) {

                $('#appointmentsTableContainer').html(
                    $(data).find('#appointmentsTableContainer').html()
                );

                $('#paginationLinks').html(
                    $(data).find('#paginationLinks').html()
                );

                filterTable(); // IMPORTANT
            });
        });

        // SEARCH AND FILTER FUNCTIONALITY
        $(document).ready(function() {
            function filterTable() {

                let search = $('#searchInput').val()?.toLowerCase().trim() || '';
                let status = $('#statusFilter').val()?.toLowerCase().trim() || '';

                let visibleRows = 0;

                const rows = $('#appointmentsTableContainer tbody tr');

                if (search === "" && status === "") {

                    rows.each(function() {

                        let row = $(this);

                        if (row.is('#serverEmptyRow') || row.is('#noResultsRow')) {
                            return;
                        }

                        row.show();
                    });

                    $('#noResultsRow').hide();
                    return;
                }

                rows.each(function() {

                    let row = $(this);

                    if (row.is('#serverEmptyRow') || row.is('#noResultsRow')) {
                        return;
                    }

                    let pet = row.find('td:nth-child(1)').text().toLowerCase();
                    let service = row.find('td:nth-child(2)').text().toLowerCase();
                    let rowStatus = row.find('.status-cell').text().toLowerCase().trim();

                    let matchSearch = pet.includes(search) || service.includes(search);
                    let matchStatus = status === "" || rowStatus.includes(status);

                    if (matchSearch && matchStatus) {
                        row.show();
                        visibleRows++;
                    } else {
                        row.hide();
                    }
                });

                $('#noResultsRow').toggle(visibleRows === 0);
            }
        });


        // RELOAD THE TABLES AUTOMATICALLY EVERY 5 SECONDS (SAFE VERSION)
        setInterval(function() {

            $.ajax({
                url: '/admin/appointments/latest-check',
                type: 'GET',
                success: function(res) {

                    if (res.hasNew) {

                        $('#appointmentsTableContainer').load(location.href +
                            " #appointmentsTableContainer > *");
                    }
                }
            });

        }, 5000);

        //  <!-- YOUR STATUS + RESCHEDULE SCRIPTS ARE STILL HERE -->
        $(document).ready(function() {

            let calendarEl = document.getElementById('calendar');

            window.calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'timeGridWeek',
                height: 750,

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                events: '/admin/appointments/calendar',

                eventContent: function(arg) {
                    return {
                        html: `
                    <div style="font-size:11px">
                        <div><strong>${arg.event.title}</strong></div>
                        <div>${arg.event.extendedProps.owner}</div>
                        <div>${arg.event.extendedProps.vet}</div>
                    </div>
                `
                    };
                },

                dateClick: function(info) {
                    window.calendar.changeView('timeGridDay', info.dateStr);
                },

                eventClick: function(info) {

                    $('#appointment_id').val(info.event.id);

                    $('#assignVetModal').modal('show');

                }

            });

            window.calendar.render();


            // ===============================
            // VIEW TOGGLE
            // ===============================

            $('#showCalendar').click(function() {

                $('#tableView').hide();
                $('#calendarView').show();

                setTimeout(() => {
                    window.calendar.updateSize();
                }, 100);

            });

            $('#showTable').click(function() {

                $('#calendarView').hide();
                $('#tableView').show();

            });

        });


        // ===============================
        // RELOAD CALENDAR (SAFE VERSION)
        // ===============================
        window.reloadCalendar = function() {

            if (!window.calendar) return;

            $.ajax({
                url: '/admin/appointments/calendar-data',
                type: 'GET',
                success: function(events) {

                    window.calendar.removeAllEvents();
                    window.calendar.addEventSource(events);

                }
            });

        };


        // ===============================
        // UPDATE STATUS
        // ===============================
        $(document).on('click', '.update-status', function(e) {

            e.preventDefault();

            let appointmentId = $(this).data('id');
            let status = $(this).data('status');

            $.ajax({

                url: '/admin/appointments/' + appointmentId + '/status',

                type: 'POST',

                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },

                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {

                        location.reload();

                    });

                },

                error: function(xhr) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message ||
                            'Unable to update appointment status.'
                    });

                }

            });

        });

        // ===============================
        // RESCHEDULE SAVE
        // ===============================
        $('#saveReschedule').click(function() {

            let id = $('#reschedule_id').val();

            $.ajax({

                url: '/admin/appointments/' + id + '/reschedule',

                type: 'POST',

                data: {
                    _token: '{{ csrf_token() }}',
                    appointment_date: $('#appointment_date').val(),
                    appointment_time: $('#appointment_time').val()
                },

                success: function(response) {

                    $('#rescheduleModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {

                        location.reload();

                    });

                },

                error: function(xhr) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message ||
                            'Unable to reschedule appointment.'
                    });

                }

            });

        });

        // ===============================
        // ASSIGN VETERINARIAN
        // ===============================
        $('#assignVetBtn').click(function() {

            $.ajax({

                url: '/admin/appointments/assign-vet',

                type: 'POST',

                data: {
                    _token: '{{ csrf_token() }}',
                    appointment_id: $('#appointment_id').val(),
                    vet_id: $('#vet_id').val()
                },

                success: function(response) {

                    $('#assignVetModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {

                        location.reload();

                    });

                },

                error: function() {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to assign veterinarian.'
                    });

                }

            });

        });

        // ===============================
        // OPEN RESCHEDULE MODAL
        // ===============================
        $(document).on('click', '.reschedule-btn', function() {

            let id = $(this).data('id');

            $('#reschedule_id').val(id);

            $('#rescheduleModal').modal('show');

        });

        // ===============================
        // OPEN ASSIGN VET MODAL
        // ===============================
        $(document).on('click', '.assign-vet-btn', function() {

            let appointmentId = $(this).data('id');

            $('#appointment_id').val(appointmentId);

            $('#assignVetModal').modal('show');

        });
    </script>
@endsection
