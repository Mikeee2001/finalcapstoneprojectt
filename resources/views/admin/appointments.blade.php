@extends('layout.app')

@section('content')
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

        .appointment-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: .5px;
        }

        .table td {
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: .2s ease;
        }

        .badge {
            font-size: 12px;
            padding: 8px 12px;
            border-radius: 50px;
        }

        .owner-name {
            font-weight: 600;
            color: #212529;
        }

        .pet-name {
            color: #0d6efd;
            font-weight: 500;
        }

        .appointment-container {
            max-width: 1400px;
            margin: auto;
        }
    </style>
    <div class="container-fluid appointment-container py-4">

        <div class="appointment-card">

            <div class="appointment-header">
                <h3>Appointment Management</h3>
                <small>Manage all pet appointments</small>
            </div>

            <div class="card-body p-4">

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Owner</th>
                            <th>Pet</th>
                            <th>Service</th>
                            <th>Assigned Vet</th>
                            <th>Appointment Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>

                                <td class="owner-name">
                                    {{ $appointment->pets->user->fullname ?? 'N/A' }}
                                </td>

                                <td class="pet-name">
                                    {{ $appointment->pets->pet_name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $appointment->service->service_name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $appointment->vets->license_number ?? 'Not Assigned' }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </td>

                                <td>
                                    @switch($appointment->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @break

                                        @case('approved')
                                            <span class="badge bg-success">Approved</span>
                                        @break

                                        @case('completed')
                                            <span class="badge bg-primary">Completed</span>
                                        @break

                                        @case('cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @endswitch
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        No appointments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $appointments->links() }}
                    </div>

                </div>
            </div>

        </div>
    @endsection
