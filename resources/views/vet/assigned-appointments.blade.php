@extends('layout.app')

@section('content')
    <style>
        body {
            background: #f6f8fc;
        }

        #calendar {
            min-height: 800px;
        }

        .fc {
            font-family: "Google Sans", "Segoe UI", sans-serif;
            font-size: 14px;
        }

        /* Calendar container */
        .fc-theme-standard {
            border: none;
        }

        .fc-scrollgrid {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb !important;
        }

        /* Header */
        .fc-toolbar-title {
            font-size: 1.5rem !important;
            font-weight: 500;
            color: #202124;
        }

        /* Buttons */
        .fc-button {
            border-radius: 8px !important;
            border: none !important;
            box-shadow: none !important;
            text-transform: capitalize !important;
        }

        .fc-button-primary {
            background: #1a73e8 !important;
        }

        .fc-button-primary:hover {
            background: #1557b0 !important;
        }

        /* Today column */
        .fc-day-today {
            background: rgba(26, 115, 232, 0.08) !important;
        }

        /* Event cards */
        .fc-event {
            border: none !important;
            border-radius: 8px !important;
            padding: 2px 4px;
            background: #1a73e8 !important;
            font-size: 12px;
            font-weight: 500;
        }

        .fc-event:hover {
            transform: scale(1.02);
            transition: .2s;
            cursor: pointer;
        }

        /* Day headers */
        .fc-col-header-cell {
            background: #fff;
            padding: 10px 0;
        }

        .fc-col-header-cell-cushion {
            text-decoration: none !important;
            color: #5f6368;
            font-weight: 600;
        }

        /* Time labels */
        .fc-timegrid-slot-label {
            color: #5f6368;
        }

        /* Grid lines */
        .fc-theme-standard td,
        .fc-theme-standard th {
            border-color: #e5e7eb !important;
        }

        /* Card */
        .calendar-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .calendar-header {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 20px;
        }

        .calendar-header h4 {
            margin: 0;
            font-weight: 500;
        }
    </style>

    <div class="container-fluid py-4">

        <div class="card calendar-card">

            <div class="calendar-header">
                <h4>
                    <i class="fa-solid fa-calendar-check text-primary me-2"></i>
                    Assigned Appointments
                </h4>
            </div>

            <div class="card-body p-3">
                <div id="calendar"></div>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {

                dayMaxEvents: true,

                slotMinTime: "07:00:00",

                slotMaxTime: "19:00:00",

                expandRows: true,

                stickyHeaderDates: true,

                initialView: 'timeGridWeek',

                height: 800,

                nowIndicator: true,

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                events: "{{ route('vet.assigned.appointment') }}",

                eventClick: function(info) {

                    Swal.fire({
                        title: info.event.title,
                                        html: `
                            <div class="text-start">
                                <p><strong>🐾 Pet:</strong> ${info.event.extendedProps.pet}</p>
                                <p><strong>🩺 Service:</strong> ${info.event.extendedProps.service}</p>
                                <p><strong>📋 Status:</strong> ${info.event.extendedProps.status}</p>
                                <p><strong>📝 Notes:</strong> ${info.event.extendedProps.notes ?? 'N/A'}</p>
                            </div>
                        `,
                        confirmButtonColor: '#1a73e8',
                        width: 500
                    });

                }

            });

            calendar.render();

            // IMPORTANT: expose globally
            window.calendar = calendar;

        });
    </script>
@endsection
