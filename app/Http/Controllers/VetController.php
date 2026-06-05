<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Pets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class VetController extends Controller
{
    public function dashboard()
    {
        return view('vet.dashboard');
    }

    public function getAppointments()
    {
        return view('vet.assigned-appointments');
    }

    public function getMedicalRecords()
    {
        return view('vet.medical-records');
    }


    public function latestCheck()
    {
        $latest = Appointments::latest()->first();

        $lastSeen = session('last_appointment_id');

        session(['last_appointment_id' => $latest->id ?? null]);

        return response()->json([
            'hasNew' => $lastSeen !== $latest->id
        ]);
    }

    public function vetSettings()
    {
        $user = auth()->user();
        $vet = $user->veterinarian;

        return view('vet.settings', compact('user', 'vet'));
    }
    public function updateVet(Request $request)
    {
        $user = auth()->user();

        if ($request->type === 'profile') {

            $request->validate([
                'fullname' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            ]);

            if (
                $user->fullname === $request->fullname &&
                $user->email === $request->email
            ) {
                return response()->json([
                    'status' => 0,
                    'message' => 'No changes detected!'
                ]);
            }

            $user->update([
                'fullname' => $request->fullname,
                'email' => $request->email,
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'Profile updated successfully!'
            ]);
        }

        if ($request->type === 'settings') {

            return response()->json([
                'status' => 1,
                'message' => 'Settings saved successfully!'
            ]);
        }

        // =========================
        // INVALID REQUEST
        // =========================
        return response()->json([
            'status' => 0,
            'message' => 'Invalid request type!'
        ]);
    }

    public function updateVetPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();

        // VERIFY CURRENT PASSWORD
        if (!Hash::check($request->current_password, $user->password)) {

            return response()->json([
                'status' => 0,
                'message' => 'Current password is incorrect.'
            ], 422);

        }

        // UPDATE PASSWORD
        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Password changed successfully!'
        ]);
    }

    public function getVetAssignedAppointments()
    {
        $vet = auth()->user()->vet;

        $appointments = $vet->appointments()
            ->with(['pets', 'service'])
            ->get();

        $statusColors = [
            'pending' => '#ffc107',
            'approved' => '#0d6efd',
            'completed' => '#198754',
            'cancelled' => '#dc3545',
            'rescheduled' => '#6c757d',
        ];

        $events = [];

        foreach ($appointments as $app) {

            $date = $app->appointment_date ?? $app->requested_date;
            $time = $app->appointment_time ?? $app->requested_time;

            $events[] = [
                'id' => $app->id,
                'title' => $app->pets->pet_name . ' - ' . $app->service->service_name,
                'start' => $date . 'T' . $time,

                'backgroundColor' => $statusColors[$app->status] ?? '#6c757d',
                'borderColor' => $statusColors[$app->status] ?? '#6c757d',

                'extendedProps' => [
                    'pet' => $app->pets->pet_name,
                    'service' => $app->service->service_name,
                    'status' => ucfirst($app->status),
                    'notes' => $app->notes,
                ]
            ];
        }

        return response()->json($events);
    }

    public function petRecords($petId)
    {
        $pet = Pets::with([

            'user',
            'species',
            'breed',

            'medicalRecords' => function ($query) {
                $query->latest();
            },

            'medicalRecords.appointment.service',

            'medicalRecords.labTests',

            'medicalRecords.vaccinations.medicine',

            'medicalRecords.prescriptions.items.medicine'

        ])->findOrFail($petId);

        return view(
            'vet.pet-medical-records-content',
            compact('pet')
        );
    }

    public function medicalRecords()
    {
        $pets = Pets::with('species')
            ->get();

        return view(
            'vet.pet-medical-records',
            compact('pets')
        );
    }



}
