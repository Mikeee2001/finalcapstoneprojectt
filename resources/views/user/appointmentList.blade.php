@extends('layout.app')

@section('content')
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

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Pet</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Notes</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($appointments as $app)
                                <tr>

                                    <td>
                                        <div class="fw-bold text-dark">
                                            {{ $app->pets->pet_name ?? 'N/A' }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="text-primary fw-semibold">
                                            {{ $app->service->service_name ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <td>
                                        <i class="fa-solid fa-calendar text-secondary me-1"></i>
                                        {{ \Carbon\Carbon::parse($app->requested_date)->format('M d, Y') }}
                                    </td>

                                    <td>
                                        <i class="fa-solid fa-clock text-secondary me-1"></i>
                                        {{ \Carbon\Carbon::parse($app->requested_time)->format('g:i A') }}
                                    </td>

                                    <td>
                                        {{ $app->notes ?: 'No Notes' }}
                                    </td>

                                    <td>

                                        @switch($app->status)
                                            @case('pending')
                                                <span class="badge rounded-pill"
                                                    style="background:#ffc107; color:#000; padding:6px 12px;">
                                                    Pending
                                                </span>
                                            @break

                                            @case('approved')
                                                <span class="badge rounded-pill"
                                                    style="background:#198754; color:#fff; padding:6px 12px;">
                                                    Approved
                                                </span>
                                            @break

                                            @case('rescheduled')
                                                <span class="badge rounded-pill"
                                                    style="background:#0dcaf0; color:#000; padding:6px 12px;">
                                                    Rescheduled
                                                </span>
                                            @break

                                            @case('cancelled')
                                                <span class="badge rounded-pill"
                                                    style="background:#343a40; color:#fff; padding:6px 12px;">
                                                    Cancelled
                                                </span>
                                            @break

                                            @case('completed')
                                                <span class="badge rounded-pill"
                                                    style="background:#0d6efd; color:#fff; padding:6px 12px;">
                                                    Completed
                                                </span>
                                            @break

                                            @case('rejected')
                                                <span class="badge rounded-pill"
                                                    style="background:#dc3545; color:#fff; padding:6px 12px;">
                                                    Rejected
                                                </span>
                                            @break

                                            @default
                                                <span class="badge rounded-pill bg-secondary px-3 py-2">
                                                    {{ ucfirst($app->status) }}
                                                </span>
                                        @endswitch

                                    </td>

                                </tr>

                                @empty

                                    <tr>
                                        <td colspan="6">

                                            <div class="text-center py-5">

                                                <i class="fa-solid fa-calendar-xmark fa-4x text-muted mb-3"></i>

                                                <h5 class="text-muted">
                                                    No appointments found
                                                </h5>

                                                <p class="text-muted mb-0">
                                                    Book your first appointment to get started.
                                                </p>

                                            </div>

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

            {{-- <script>
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
    </script> --}}
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


        </div>
        </div>
    @endsection
