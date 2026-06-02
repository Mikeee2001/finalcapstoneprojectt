<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Appointment Status Update</title>
</head>

<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7fb;padding:40px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#2563eb;color:white;padding:30px 20px;">
                            <h1 style="margin:0;font-size:28px;">
                                VetCare System
                            </h1>
                            <p style="margin-top:8px;font-size:14px;">
                                Veterinary Clinic Management
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;">

                            <h2 style="margin-top:0;color:#111827;">
                                Hello {{ $user->fullname ?? 'Client' }},
                            </h2>

                            <p style="color:#4b5563;font-size:16px;line-height:1.8;">
                                Your appointment status has been updated.
                            </p>

                            <!-- Status Card -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background:#eff6ff;border-left:5px solid #2563eb;border-radius:8px;margin:25px 0;">
                                <tr>
                                    <td style="padding:20px;">
                                        <strong>Status:</strong>
                                        <span style="color:#2563eb;font-weight:bold;">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <!-- Appointment Details -->
                            <h3 style="color:#111827;margin-bottom:15px;">
                                Appointment Details
                            </h3>

                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse:collapse;border:1px solid #e5e7eb;">

                                <tr>
                                    <td style="background:#f9fafb;font-weight:bold;">
                                        Pet Name
                                    </td>
                                    <td>
                                        {{ $appointment->pets->pet_name ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="background:#f9fafb;font-weight:bold;">
                                        Service
                                    </td>
                                    <td>
                                        {{ $appointment->service->service_name ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="background:#f9fafb;font-weight:bold;">
                                        Date
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="background:#f9fafb;font-weight:bold;">
                                        Time
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                    </td>
                                </tr>

                            </table>

                            @if ($status == 'rescheduled')
                                <div
                                    style="margin-top:25px;padding:20px;background:#fef3c7;border-left:5px solid #f59e0b;border-radius:8px;">
                                    <strong>Rescheduled Appointment</strong>
                                    <p style="margin-top:10px;">
                                        Your appointment has been moved to:
                                    </p>

                                    <p style="font-size:18px;font-weight:bold;color:#92400e;">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                                        at
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                    </p>
                                </div>
                            @endif

                            <div style="text-align:center;margin-top:35px;">
                                <a href="{{ url('/signin') }}"
                                    style="background:#2563eb;color:white;padding:14px 30px;text-decoration:none;border-radius:8px;font-weight:bold;">
                                    View Appointment
                                </a>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background:#f9fafb;padding:20px;color:#6b7280;font-size:13px;">
                            © {{ date('Y') }} VetCare System
                            <br>
                            Thank you for trusting our veterinary clinic.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
