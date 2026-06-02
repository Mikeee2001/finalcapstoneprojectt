@extends('layout.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Assigned Appointments</h1>

        <div id="appointments-container">
            <!-- Appointments will be loaded here -->
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.get('/vet/assigned-appointments', function(data) {
                if (data.status === 1) {
                    let appointmentsHtml = '';
                    data.appointments.forEach(function(appointment) {
                        appointmentsHtml += `
                            <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                                <h3 class="text-xl font-bold">${appointment.pets[0].name}</h3>
                                <p class="text-gray-600">${appointment.services[0].service_name}</p>
                                <p class="text-sm text-gray-500">${appointment.date} at ${appointment.time}</p>
                            </div>
                        `;
                    });
                    $('#appointments-container').html(appointmentsHtml);
                }
            });
        });
    </script>
@endsection
