<?php

namespace App\Http\Controllers;

use App\Mail\VetAccountMail;
use App\Models\Appointments;
use App\Models\Categories;
use App\Models\Services;
use App\Models\Specialization;
use App\Models\User;
use App\Models\Vet;
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
        return view('admin.service');
    }


    public function userList()
    {
        $users = User::whereIn('role', ['admin', 'user', 'staff'])->orderBy('created_at', 'desc')
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

    public function categories()
    {
        $services = Services::with('category')
            ->latest()
            ->paginate(10);

        $categories = Categories::all();

        return view('admin.service', compact('services', 'categories'));
    }


    public function addService(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_description' => 'nullable|string',
            'price' => 'required|numeric',

            'category_id' => 'required',

            'new_category' => 'nullable|string|max:255',

            'status' => 'required|in:active,nactive',
        ]);

        // =========================
        // CREATE OR GET CATEGORY
        // =========================
        if ($request->category_id === 'new') {

            $newName = trim($request->new_category);

            if (!$newName) {
                return response()->json([
                    'status' => 0,
                    'message' => 'New category name is required.'
                ], 422);
            }

            // CHECK FOR DUPLICATE (case-insensitive)
            $category = Categories::whereRaw('LOWER(category_name) = ?', [strtolower($newName)])
                ->first();

            // IF EXISTS → reuse it
            if (!$category) {
                $category = Categories::create([
                    'category_name' => $newName
                ]);
            }

            $category_id = $category->id;

        } else {
            $category_id = $request->category_id;
        }
        // =========================
        // CREATE SERVICE
        // =========================
        Services::create([
            'service_name' => $request->service_name,
            'service_description' => $request->service_description,
            'price' => $request->price,
            'category_id' => $category_id,
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

    public function fetchAppointmentsAll()
    {
        $appointments = Appointments::with([
            'pets.user',
            'vets',
            'service',
        ])->latest()->paginate(5);

        $calendarAppointments = Appointments::with([
            'pets.user',
            'vets',
            'service',
        ])->get();

        $statusColors = [
            'pending' => '#ffc107',
            'approved' => '#198754',
            'completed' => '#0d6efd',
            'cancelled' => '#dc3545',
            'rescheduled' => '#0dcaf0',
        ];

        $vets = Vet::all();

        return view('admin.appointments', compact(
            'appointments',
            'calendarAppointments',
            'vets',
            'statusColors'
        ));
    }
}
