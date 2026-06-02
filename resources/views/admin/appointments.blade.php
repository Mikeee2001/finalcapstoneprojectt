@extends('layout.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>

    <style>
        .appointment-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .appointment-header {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            color: white;
            padding: 20px;
        }

        .appointment-container {
            max-width: 1400px;
            margin: auto;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .appointment-status {
            min-width: 110px;
            text-align: center;
            font-size: 13px;
            display: inline-block;
            font-weight: 600;
        }

        .card {
            border-radius: 16px;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .table td {
            padding: 16px 12px;
        }
    </style>

    <div class="container-fluid appointment-container py-4">

        <!-- TOGGLE BUTTONS (KEPT SAFE) -->
        <div class="mb-3 text-end">
            <button id="showTable" class="btn btn-primary btn-sm">Table View</button>
            <button id="showCalendar" class="btn btn-success btn-sm">Calendar View</button>
        </div>

        <!-- ================= TABLE VIEW (YOUR ORIGINAL CODE KEPT) ================= -->
        <div id="tableView">

            <div class="card border-0 shadow rounded-4 overflow-hidden">

                <div class="bg-primary text-white p-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-calendar-check me-2"></i>
                        Appointment Management
                    </h4>

                    <span class="badge bg-light text-primary px-3 py-2">
                        {{ $appointments->total() }} Appointments
                    </span>
                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th>Pet</th>
                                    <th>Owner</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Assigned Vet</th>
                                    <th>Status</th>
                                    <th width="220">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($appointments as $appointment)
                                    <tr>

                                        <td>
                                            <strong>
                                                {{ $appointment->pets->pet_name ?? 'N/A' }}
                                            </strong>
                                        </td>

                                        <td>
                                            {{ $appointment->pets->user->fullname ?? 'N/A' }}
                                        </td>

                                        <td>
                                            <span class="text-primary fw-semibold">
                                                {{ $appointment->service->service_name ?? 'N/A' }}
                                            </span>
                                        </td>

                                        <td>
                                            <i class="fa-solid fa-calendar-days text-secondary me-1"></i>
                                            {{ \Carbon\Carbon::parse($appointment->requested_date)->format('M d, Y') }}
                                        </td>

                                        <td>
                                            <i class="fa-solid fa-clock text-secondary me-1"></i>
                                            {{ \Carbon\Carbon::parse($appointment->requested_time)->format('g:i A') }}
                                        </td>

                                        <td>
                                            {{ $appointment->vets->fullname ?? 'Not Assigned' }}
                                        </td>

                                        <td>

                                            @if ($appointment->status == 'pending')
                                                <span
                                                    class="badge rounded-pill appointment-status bg-warning text-dark px-3 py-2">
                                                    Pending
                                                </span>
                                            @elseif($appointment->status == 'approved')
                                                <span class="badge rounded-pill appointment-status bg-info px-3 py-2">
                                                    Approved
                                                </span>
                                            @elseif($appointment->status == 'completed')
                                                <span class="badge rounded-pill appointment-status bg-primary px-3 py-2">
                                                    Completed
                                                </span>
                                            @elseif($appointment->status == 'cancelled')
                                                <span class="badge rounded-pill appointment-status bg-dark px-3 py-2">
                                                    Cancelled
                                                </span>
                                            @elseif($appointment->status == 'rescheduled')
                                                <span class="badge rounded-pill appointment-status bg-secondary px-3 py-2">
                                                    Rescheduled
                                                </span>
                                            @endif

                                        </td>

                                        <td>

                                            @if ($appointment->status == 'pending')
                                                <button class="btn btn-success btn-sm update-status"
                                                    data-id="{{ $appointment->id }}" data-status="approved">
                                                    Approve
                                                </button>

                                                <button class="btn btn-danger btn-sm update-status"
                                                    data-id="{{ $appointment->id }}" data-status="cancelled">
                                                    Cancel
                                                </button>
                                            @elseif($appointment->status == 'approved')
                                                <button class="btn btn-primary btn-sm update-status"
                                                    data-id="{{ $appointment->id }}" data-status="completed">
                                                    Complete
                                                </button>

                                                <button class="btn btn-warning btn-sm reschedule-btn"
                                                    data-id="{{ $appointment->id }}">
                                                    Reschedule
                                                </button>
                                            @elseif($appointment->status == 'completed')
                                                <span class="badge bg-success">
                                                    Finished
                                                </span>
                                            @elseif($appointment->status == 'cancelled')
                                                <span class="badge bg-danger">
                                                    Cancelled
                                                </span>
                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            No appointments found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="p-3">
                        {{ $appointments->links() }}
                    </div>

                </div>

            </div>

        </div>
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

        <!-- ================= CALENDAR VIEW (ADDED ONLY - NO DELETION) ================= -->
        <div id="calendarView" style="display:none;">
            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= YOUR EXISTING MODALS (UNCHANGED) ================= -->
    <div class="modal fade" id="assignVetModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Assign Veterinarian</h5>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="appointment_id">

                    <select id="vet_id" class="form-select">
                        @foreach ($vets as $vet)
                            <option value="{{ $vet->id }}">{{ $vet->fullname }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= YOUR EXISTING SCRIPTS (NOT REMOVED) ================= -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- YOUR STATUS + RESCHEDULE SCRIPTS ARE STILL HERE -->
    <script>
        $(document).on('click', '.update-status', function() {

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
                    });
                }
            });

        });
    </script>

    <script>
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
                        text: xhr.responseJSON?.message ??
                            'Unable to reschedule appointment.'
                    });

                }
            });

        });
    </script>

    <script>
        $(document).on('click', '.reschedule-btn', function() {
            let id = $(this).data('id');
            $('#reschedule_id').val(id);
            $('#rescheduleModal').modal('show');
        });
    </script>

    <!-- ================= FULLCALENDAR (ADDED ONLY) ================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'timeGridWeek',
                height: 750,

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                events: [

                    @foreach ($calendarAppointments as $appointment)

                        {
                            id: '{{ $appointment->id }}',

                            title: '{{ $appointment->pets->pet_name ?? 'No Pet' }}',

                            start: '{{ $appointment->requested_date }}T{{ $appointment->requested_time }}',

                            color: '{{ $statusColors[$appointment->status] ?? '#6c757d' }}',

                            extendedProps: {
                                owner: '{{ $appointment->pets->user->fullname ?? 'N/A' }}',
                                service: '{{ $appointment->service->service_name ?? 'N/A' }}',
                                status: '{{ ucfirst($appointment->status) }}'
                            }
                        },
                    @endforeach

                ],

                dateClick: function(info) {
                    calendar.changeView('timeGridDay', info.dateStr);
                },

                eventClick: function(info) {
                    $('#appointment_id').val(info.event.id);
                    $('#assignVetModal').modal('show');
                }

            });

            calendar.render();

            // TOGGLE VIEW (SAFE - ADDED ONLY)
            $('#showCalendar').click(function() {
                $('#tableView').hide();
                $('#calendarView').show();
                setTimeout(() => calendar.updateSize(), 100);
            });

            $('#showTable').click(function() {
                $('#calendarView').hide();
                $('#tableView').show();
            });

        });
    </script>
@endsection
