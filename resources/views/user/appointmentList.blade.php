@extends('layout.app')

@section('content')
    <style>
        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, .08);
        }

        .card {
            overflow: hidden;
        }

        .badge {
            font-size: .85rem;
            letter-spacing: .3px;
        }

        .pagination {
            margin-bottom: 0;
        }
    </style>

    <div class="container-fluid">

        <div class="card border-0 shadow-lg rounded-4">

            <div class="card-header bg-primary text-white py-3 rounded-top-4">
                <div class="d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">
                        <i class="fa-solid fa-calendar-check me-2"></i>
                        My Appointments
                    </h4>

                    <span class="badge bg-light text-primary fs-6">
                        {{ $appointments->total() }} Appointments
                    </span>

                </div>
            </div>

            <div class="card-body p-4">


                <div id="appointmentsTableContainer" class="table-responsive">

                    <table class="table align-middle table-hover mb-0">

                        <!-- HEADER -->
                        <thead class="table-primary text-dark">
                            <tr>
                                <th>Pet</th>
                                <th>Service</th>
                                <th>Assigned Vet</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Notes</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($appointments as $app)
                                <tr class="align-middle">

                                    <!-- PET -->
                                    <td>
                                        <div class="d-flex align-items-center gap-2">

                                            <!-- PET IMAGE -->
                                            @if ($app->pets && $app->pets->pet_image)
                                                <img src="{{ asset('pet_images/' . $app->pets->pet_image) }}"
                                                    class="rounded-circle border" width="40" height="40"
                                                    style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                    style="width:45px; height:45px;">
                                                    <i class="fa-solid fa-paw text-white"></i>
                                                </div>
                                            @endif

                                            <!-- PET INFO -->
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-dark">
                                                    {{ $app->pets->pet_name ?? 'N/A' }}
                                                </span>

                                                <small class="text-muted">
                                                    {{ $app->pets->breed->breed_name ?? 'No Breed' }}
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    <!-- SERVICE -->
                                    <td>
                                        <span class="badge bg-light text-primary border px-3 py-2">
                                            {{ $app->service->service_name ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <!-- VET -->
                                    <td>
                                        @if ($app->vets)
                                            <div class="d-flex align-items-center gap-2">

                                                <img src="{{ asset('storage/' . $app->vets->image) }}"
                                                    class="rounded-circle border" width="40" height="40"
                                                    style="object-fit: cover;">

                                                <div>
                                                    <div class="fw-semibold">
                                                        Dr. {{ $app->vets->user->fullname ?? 'N/A' }}
                                                    </div>
                                                    <small class="text-muted">Veterinarian</small>
                                                </div>

                                            </div>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2">
                                                Not Assigned
                                            </span>
                                        @endif
                                    </td>

                                    <!-- DATE -->
                                    <td>
                                        <div class="fw-semibold">
                                            {{ \Carbon\Carbon::parse($app->requested_date)->format('M d, Y') }}
                                        </div>
                                    </td>

                                    <!-- TIME -->
                                    <td>
                                        <span class="badge bg-dark px-3 py-2">
                                            {{ \Carbon\Carbon::parse($app->requested_time)->format('g:i A') }}
                                        </span>
                                    </td>

                                    <!-- NOTES -->
                                    <td style="max-width: 200px;">
                                        <small class="text-muted">
                                            {{ $app->notes ?: 'No notes provided' }}
                                        </small>
                                    </td>

                                    <!-- STATUS -->
                                    <td>
                                        @switch($app->status)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                            @break

                                            @case('approved')
                                                <span class="badge bg-success px-3 py-2">Approved</span>
                                            @break

                                            @case('completed')
                                                <span class="badge bg-primary px-3 py-2">Completed</span>
                                            @break

                                            @case('cancelled')
                                                <span class="badge bg-danger px-3 py-2">Cancelled</span>
                                            @break

                                            @case('rescheduled')
                                                <span class="badge bg-info text-dark px-3 py-2">Rescheduled</span>
                                            @break

                                            @default
                                                <span class="badge bg-secondary px-3 py-2">
                                                    {{ ucfirst($app->status) }}
                                                </span>
                                        @endswitch
                                    </td>

                                </tr>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fa-solid fa-calendar-xmark fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">No appointments found</h6>
                                            <small class="text-muted">Book your first appointment to get started</small>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>
                    </div>

                </div>

                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-center">
                        {{ $appointments->links() }}
                    </div>
                </div>

            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                $(document).ready(function() {

                    $('#appointmentTable').DataTable({
                        responsive: true,
                        pageLength: 5,
                        lengthMenu: [
                            [5, 10, 25, 50, 100],
                            [5, 10, 25, 50, 100]
                        ]
                    });

                });
            </script>

            <script>
                // RELOAD THE TABLES AUTOMATICALLY EVERY 5 SECONDS (SAFE VERSION)
                setInterval(function() {

                    $.ajax({
                        url: '/user/appointments/latest-check',
                        type: 'GET',
                        success: function(res) {

                            if (res.hasNew) {

                                $('#appointmentsTableContainer').load(location.href +
                                    " #appointmentsTableContainer > *");
                            }
                        }
                    });

                }, 5000);
            </script>
        @endsection
