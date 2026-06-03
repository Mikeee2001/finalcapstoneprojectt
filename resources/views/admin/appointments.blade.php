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
    </style>
    <div class="container-fluid appointment-container py-4">



        <!-- TOGGLE BUTTONS (KEPT SAFE) -->
        <div class="mb-3 text-end">
            <button id="showTable" class="btn btn-primary btn-sm">Table View</button>
            <button id="showCalendar" class="btn btn-success btn-sm">Calendar View</button>
        </div>

        <!-- ================= TABLE VIEW  ================= -->

        <!-- TOP STATS -->
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="stat-card stat-blue">
                    <i class="fa-solid fa-calendar-check"></i>
                    <h3>{{ $appointments->total() }}</h3>
                    <span>Total Appointments</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card stat-yellow">
                    <i class="fa-solid fa-clock"></i>
                    <h3>{{ $pendingCount }}</h3>
                    <span>Pending</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card stat-green">
                    <i class="fa-solid fa-circle-check"></i>
                    <h3>{{ $approvedCount }}</h3>
                    <span>Approved</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card stat-teal">
                    <i class="fa-solid fa-stethoscope"></i>
                    <h3>{{ $completedCount }}</h3>
                    <span>Completed</span>
                </div>
            </div>

        </div>

        <!-- SEARCH + FILTER -->
        <div class="row mb-4">

            <div class="col-md-8">
                <input type="text" class="form-control search-box" placeholder="Search pet, owner, service...">
            </div>

            <div class="col-md-4">
                <select class="form-select">
                    <option>All Status</option>
                    <option>Pending</option>
                    <option>Approved</option>
                    <option>Completed</option>
                    <option>Cancelled</option>
                </select>
            </div>

        </div>

        <!-- TABLE CARD -->
        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white border-0 py-3">

                <h5 class="mb-0">
                    <i class="fa-solid fa-calendar-check text-primary"></i>
                    Appointment Management
                </h5>

            </div>

            <div class="table-responsive">

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

                    <tbody>

                        @foreach ($appointments as $appointment)
                            <tr>

                                <td>
                                    <div class="d-flex align-items-center">

                                        <div class="pet-avatar me-3">
                                            <i class="fa-solid fa-paw"></i>
                                        </div>

                                        <div>
                                            <div class="fw-bold">
                                                {{ $appointment->pets->pet_name }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $appointment->pets->user->fullname }}
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    {{ $appointment->service->service_name }}
                                </td>

                                <td>
                                    <div>
                                        {{ Carbon\Carbon::parse($appointment->appointment_date ?? $appointment->requested_date)->format('M d, Y') }}
                                    </div>

                                    <small class="text-muted">
                                        {{ Carbon\Carbon::parse($appointment->appointment_time ?? $appointment->requested_time)->format('h:i A') }}
                                    </small>
                                </td>

                                <td>

                                    @if ($appointment->vets)
                                        <span class="vet-badge">

                                            <i class="fa-solid fa-user-doctor me-1"></i>

                                            {{ $appointment->vets->user->fullname }}

                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Not Assigned
                                        </span>
                                    @endif

                                </td>

                                <td class="status-cell">
                                    @if ($appointment->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($appointment->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($appointment->status == 'completed')
                                        <span class="badge bg-primary">Completed</span>
                                    @elseif($appointment->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif($appointment->status == 'rescheduled')
                                        <span class="badge bg-secondary">Rescheduled</span>
                                    @endif
                                </td>

                                <td class="action-cell">

                                    <div class="dropdown">

                                        <button class="btn btn-light border" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end">

                                            {{-- PENDING --}}
                                            @if ($appointment->status == 'pending')
                                                <li>
                                                    <a class="dropdown-item update-status" data-id="{{ $appointment->id }}"
                                                        data-status="approved">
                                                        <i class="fa-solid fa-check me-2"></i>
                                                        Approve
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item update-status" data-id="{{ $appointment->id }}"
                                                        data-status="cancelled">
                                                        <i class="fa-solid fa-xmark me-2"></i>
                                                        Cancel
                                                    </a>
                                                </li>

                                                {{-- APPROVED --}}
                                            @elseif($appointment->status == 'approved')
                                                <li>
                                                    <a class="dropdown-item update-status" data-id="{{ $appointment->id }}"
                                                        data-status="completed">
                                                        <i class="fa-solid fa-circle-check me-2"></i>
                                                        Complete
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item reschedule-btn"
                                                        data-id="{{ $appointment->id }}">
                                                        <i class="fa-solid fa-calendar-days me-2"></i>
                                                        Reschedule
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item assign-vet-btn"
                                                        data-id="{{ $appointment->id }}">
                                                        <i class="fa-solid fa-user-doctor me-2"></i>
                                                        Assign Vet
                                                    </a>
                                                </li>

                                                {{-- RESCHEDULED --}}
                                            @elseif($appointment->status == 'rescheduled')
                                                <li>
                                                    <a class="dropdown-item update-status" data-id="{{ $appointment->id }}"
                                                        data-status="completed">
                                                        <i class="fa-solid fa-circle-check me-2"></i>
                                                        Complete
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item assign-vet-btn"
                                                        data-id="{{ $appointment->id }}">
                                                        <i class="fa-solid fa-user-doctor me-2"></i>
                                                        Assign Vet
                                                    </a>
                                                </li>
                                            @endif

                                        </ul>

                                    </div>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>


                </table>

                <div class="card-footer bg-white border-0 d-flex justify-content-end">
                    {{ $appointments->links() }}
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

    <!-- YOUR STATUS + RESCHEDULE SCRIPTS ARE STILL HERE -->
    <script>
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
