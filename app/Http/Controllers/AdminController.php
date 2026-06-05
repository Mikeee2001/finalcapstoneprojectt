<?php

namespace App\Http\Controllers;

use App\Mail\VetAccountMail;
use App\Models\Appointments;
use App\Models\Services;
use App\Models\Specialization;
use App\Models\User;
use App\Models\Vet;
use App\Notifications\AssignedVetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class AdminController extends Controller
{

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function settings()
    {
        return view('admin.setting');
    }

    public function services()
    {
        $services = Services::latest()->paginate(10);

        return view('admin.service', compact('services'));
    }

    public function userList()
    {
        $users = User::whereIn('role', ['admin', 'user'])->orderBy('created_at', 'desc')
            ->simplePaginate(10);
        $specializations = Specialization::all();
        return view('admin.users', compact('users', 'specializations'));
    }

    public function toggleVetStatus(Request $request)
    {
        $request->validate([

            'vet_id' => 'required|exists:veterinarian,id',
            'status' => 'required|in:available,not_available'

        ]);

        $vet = Vet::findOrFail($request->vet_id);
        $vet->update([
            'status' => $request->status
        ]);
        return response()->json([
            'status' => 1,
            'message' => 'Vet status updated successfully.'

        ]);
    }

    // ==========================
    // FETCH VETS
    // ==========================
    public function fetchVets()
    {
        $vets = Vet::with(['user', 'specializations'])->latest()->get();

        $formatted = $vets->map(function ($vet) {

            return [

                'id' => $vet->id,
                'image' => $vet->image
                    ? asset('storage/' . $vet->image)
                    : null,
                'fullname' => $vet->user->fullname ?? 'N/A',
                'email' => $vet->user->email ?? 'N/A',
                'specializations' => $vet->specializations
                    ->pluck('specialization_name')
                    ->implode(', '),
                'license' => $vet->license_number,
                'hired' => $vet->hire_date,
                'role' => 'Veterinarian',
                'status' => $vet->status,
            ];
        });

        return response()->json($formatted);
    }
    public function fetch()
    {
        $users = User::whereIn('role', [
            'admin',
            'user',
            'staff'
        ])->latest()->get();

        return response()->json($users);
    }

    // 🗑 DELETE USER
    public function delete($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'status' => 1,
            'message' => 'User deleted successfully'
        ]);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        }

        User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'User created successfully!'
        ]);
    }

    public function update(Request $request)
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

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();

        // Verify current password
        if (!\Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 0,
                'message' => 'Current password is incorrect.'
            ], 422);
        }

        // Update password
        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Password changed successfully!'
        ]);
    }

    // ==========================
    // CREATE VET
    // ==========================

    public function createVet(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'license_number' => 'required|string|unique:veterinarian,license_number',
            'hire_date' => 'required|date',
        ]);

        // GENERATE TEMP PASSWORD
        $tempPassword = Str::random(8);

        // CREATE USER
        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'role' => 'vet',
        ]);

        // STORE IMAGE
        $imagePath = $request
            ->file('image')
            ->store('veterinarians', 'public');

        // CREATE VET
        $vet = Vet::create([
            'user_id' => $user->id,
            'license_number' => $request->license_number,
            'hire_date' => $request->hire_date,
            'status' => 'available',
            'image' => $imagePath,
        ]);

        // SPECIALIZATION IDS
        $specializationIds = [];

        // EXISTING SPECIALIZATIONS
        if ($request->specializations) {
            $specializationIds = $request->specializations;
        }

        // NEW SPECIALIZATIONS
        if ($request->new_specializations) {

            $newSpecializations = explode(',', $request->new_specializations);

            foreach ($newSpecializations as $specializationName) {
                $specializationName = trim($specializationName);
                if ($specializationName != '') {
                    $specialization = Specialization::firstOrCreate([
                        'specialization_name' => $specializationName
                    ]);
                    $specializationIds[] = $specialization->id;
                }
            }
        }
        $vet->specializations()->sync($specializationIds);

        // SEND EMAIL
        Mail::to($user->email)->send(
            new VetAccountMail($user, $tempPassword)
        );

        return response()->json([
            'status' => 1,
            'message' => 'Veterinarian created successfully.',
        ]);
    }


    // ==========================
    // DELETE VET
    // ==========================

    public function deleteVet($id)
    {

        $vet = User::findOrFail($id);

        $vet->delete();

        return response()->json([

            'status' => 1,
            'message' => 'Veterinarian deleted successfully.'

        ]);

    }

    // ==========================
    // SHOW VET
    // ==========================
    public function showVet($id)
    {

        $vet = Vet::with(['user', 'specializations'])
            ->findOrFail($id);
        $vet->image = asset('storage/' . $vet->image);

        return response()->json($vet);

    }


    public function updateVet(Request $request, $id)
    {
        $vet = Vet::findOrFail($id);

        if ($request->filled('fullname')) {
            $vet->user->fullname = $request->fullname;
        }

        if ($request->filled('email')) {
            $vet->user->email = $request->email;
        }

        $vet->user->save();

        if ($request->filled('license_number')) {
            $vet->license_number = $request->license_number;
        }

        if ($request->filled('hire_date')) {
            $vet->hire_date = $request->hire_date;
        }

        if ($request->filled('status')) {
            $vet->status = $request->status;
        }

        if ($request->hasFile('image')) {

            if ($vet->image && Storage::disk('public')->exists($vet->image)) {
                Storage::disk('public')->delete($vet->image);
            }

            $vet->image = $request->file('image')
                ->store('veterinarians', 'public');
        }

        $vet->save();

        return response()->json([
            'message' => 'Veterinarian updated successfully.'
        ]);
    }

    // public function services()
    // {
    //     $services = Services::with('category')
    //         ->latest()
    //         ->paginate(10);

    //     $categories = Categories::all();

    //     return view('admin.service', compact('services'));
    // }


    public function addService(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_description' => 'nullable|string',
            'price' => 'required|numeric',

            'status' => 'required|in:active,inactive',
        ]);


        // =========================
        // CREATE SERVICE
        // =========================
        Services::create([
            'service_name' => $request->service_name,
            'service_description' => $request->service_description,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Service added successfully.'
        ]);
    }

    public function toggleServiceStatus($id)
    {
        $service = Services::findOrFail($id);

        // TOGGLE STATUS
        $service->status = $service->status === 'active' ? 'inactive' : 'active';
        $service->save();

        return response()->json([
            'success' => true,
            'status' => $service->status
        ]);
    }

    public function fetchAppointmentsAll(Request $request)
    {
        $query = Appointments::with(['pets.user', 'service', 'vets.user']);

        // STATUS FILTER
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // SEARCH FILTER
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('pets', function ($p) use ($search) {
                    $p->where('pet_name', 'like', "%$search%");
                })
                    ->orWhereHas('service', function ($s) use ($search) {
                        $s->where('service_name', 'like', "%$search%");
                    })
                    ->orWhereHas('pets.user', function ($u) use ($search) {
                        $u->where('fullname', 'like', "%$search%");
                    });
            });
        }


        // 4. Paginated result (ONLY ONCE)
        $appointments = $query->latest()->paginate(10);

        // 5. Calendar version (optional - keep unfiltered OR reuse filtered if needed)
        $calendarAppointments = Appointments::with(['pets.user', 'vets', 'service'])->get();

        // 6. Counts (you can also make these dynamic later if needed)
        $totalCount = Appointments::count();
        $pendingCount = Appointments::where('status', 'pending')->count();
        $approvedCount = Appointments::where('status', 'approved')->count();
        $completedCount = Appointments::where('status', 'completed')->count();
        $cancelledCount = Appointments::where('status', 'cancelled')->count();

        // 7. Vets
        $vets = Vet::with('user')->where('status', 'available')->get();

        $statusColors = [
            'pending' => '#ffc107',
            'approved' => '#0d6efd',
            'completed' => '#198754',
            'cancelled' => '#dc3545',
            'rescheduled' => '#6c757d',
        ];

        $appointments->getCollection()->transform(function ($appointment) use ($statusColors) {
            $appointment->status_color =
                $statusColors[$appointment->status] ?? '#6c757d';

            return $appointment;
        });

        return view('admin.appointments', compact(
            'appointments',
            'calendarAppointments',
            'vets',
            'pendingCount',
            'approvedCount',
            'completedCount',
            'cancelledCount',
            'totalCount'
        ));
    }

    public function calendarData()
    {
        $appointments = Appointments::with([
            'pets.user',
            'vets'
        ])->get();

        $statusColors = [
            'pending' => '#ffc107', // warning
            'approved' => '#0d6efd', // primary
            'completed' => '#198754', // success
            'cancelled' => '#dc3545', // danger
            'rescheduled' => '#6c757d', // secondary
        ];

        $events = $appointments->map(function ($appointment) use ($statusColors) {

            $date = $appointment->appointment_date ?? $appointment->requested_date;
            $time = $appointment->appointment_time ?? $appointment->requested_time;

            return [
                'id' => $appointment->id,

                'title' => $appointment->pets->pet_name ?? 'No Pet',

                'start' => $date . 'T' . $time,

                'backgroundColor' => $statusColors[$appointment->status] ?? '#6c757d',
                'borderColor' => $statusColors[$appointment->status] ?? '#6c757d',
                'textColor' => '#ffffff',

                'extendedProps' => [
                    'owner' => $appointment->pets->user->fullname ?? 'No Owner',
                    'vet' => $appointment->vets && $appointment->vets->user
                        ? $appointment->vets->user->fullname
                        : 'No assigned vet',
                    'status' => $appointment->status,
                ]
            ];
        });

        return response()->json($events);
    }

    public function assignVet(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'vet_id' => 'required|exists:veterinarian,id',
        ]);

        $appointment = Appointments::findOrFail(
            $request->appointment_id
        );

        $appointment->vet_id = $request->vet_id;
        $appointment->save();

        $vet = Vet::with('user')->findOrFail($request->vet_id);

        $vet->user->notify(
            new AssignedVetNotification([
                'user' => auth()->user()->fullname,
                'action' => 'Appointment Assigned',
                'message' => 'A new appointment has been assigned to you.',
                'appointment' => $appointment,
                'vet' => $vet,
            ])
        );

        return response()->json([
            'success' => true,
            'message' => 'Veterinarian assigned successfully.'
        ]);
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

}
