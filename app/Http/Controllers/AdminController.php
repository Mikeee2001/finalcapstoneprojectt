<?php

namespace App\Http\Controllers;

use App\Mail\VetAccountMail;
use App\Models\Specialization;
use App\Models\User;
use App\Models\Vet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function userList()
    {
        $users = User::whereIn('role', ['admin','user'])->orderBy('created_at', 'desc')
            ->simplePaginate(10);

        return view('admin.users', compact('users'));
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
        $vets = Vet::with(['user', 'specializations'])->get();

        $formatted = $vets->map(function ($vet) {

            return [

                'id' => $vet->id,

                'fullname' => $vet->user->fullname ?? 'N/A',

                'email' => $vet->user->email ?? 'N/A',

                'specialization' => $vet->specializations
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
        return response()->json(User::latest()->get());
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

        // CREATE VET
        $vet = Vet::create([

            'user_id' => $user->id,

            'license_number' => $request->license_number,

            'hire_date' => $request->hire_date,

            'status' => 'available',

        ]);

        // ARRAY FOR ALL SPECIALIZATION IDS
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

                    // CHECK IF EXISTS
                    $specialization = Specialization::firstOrCreate([

                        'specialization_name' => $specializationName

                    ]);

                    $specializationIds[] = $specialization->id;

                }

            }

        }

        // ATTACH SPECIALIZATIONS
        $vet->specializations()->sync($specializationIds);

        // SEND EMAIL
        Mail::to($user->email)->send(
            new VetAccountMail($user, $tempPassword)
        );

        return response()->json([

            'status' => 1,

            'message' => 'Veterinarian created successfully.'

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

        return response()->json($vet);

    }

}
