<?php

namespace App\Http\Controllers;

use App\Events\NotificationCreated;
use App\Models\Appointments;
use App\Models\Breeds;
use App\Models\Pets;
use App\Models\Services;
use App\Models\Species;
use App\Models\User;
use App\Notifications\AppointmentNotification;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getuserDashboard()
    {
        return view('user.dashboard');
    }

    public function userSettings()
    {
        return view('user.settings');
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

    public function updateUser(Request $request)
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

    public function updateUserPassword(Request $request)
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

    public function createPet(Request $request)
    {
        $request->validate([

            'pet_name' => 'required|string|max:255',
            'species_name' => 'required|string|max:255',
            'breed_name' => 'required|string|max:255',
            'gender' => 'required|string|max:50',
            'age' => 'required|integer|min:0',
            'age_type' => 'required|in:months,years',

            'pet_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        // CHECK DUPLICATE PET
        $exists = Pets::where('user_id', auth()->id())
            ->where('pet_name', $request->pet_name)
            ->exists();

        if ($exists) {

            return response()->json([
                'status' => 0,
                'message' => 'Pet already exists.'
            ], 422);
        }

        // FIND OR CREATE SPECIES
        $species = Species::firstOrCreate([
            'species_name' => ucwords(trim($request->species_name))
        ]);

        // FIND OR CREATE BREED
        $breed = Breeds::firstOrCreate([
            'breed_name' => ucwords(trim($request->breed_name)),
            'species_id' => $species->id
        ]);

        // IMAGE UPLOAD
        $imageName = null;

        if ($request->hasFile('pet_image')) {
            $image = $request->file('pet_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('pet_images'), $imageName);
        }

        // CREATE PET
        $pet = Pets::create([

            'pet_name' => $request->pet_name,
            'species_id' => $species->id,
            'breed_id' => $breed->id,
            'gender' => $request->gender,
            'age' => $request->age,
            'age_type' => $request->age_type,
            'pet_image' => $imageName,
            'user_id' => auth()->id(),

        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Pet added successfully!',
            'pet' => $pet
        ]);
    }
    public function petList()
    {
        $species = Species::all();
        $breeds = Breeds::all();

        $pets = auth()->user()->pets()->latest()->paginate(6);

        return view('user.pets', compact('pets', 'species', 'breeds'));
    }

    public function deletePet($id)
    {
        Pets::findOrFail($id)->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Pet deleted successfully'
        ]);
    }

    public function getAppointmentForm()
    {
        $pets = Pets::where('user_id', auth()->id())->get();

        $services = Services::where('status', 'active')->get();

        return view('user.appointment-form', [
            'pets' => $pets,
            'services' => $services,
        ]);
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'service_id' => 'required|exists:services,id',
            'requested_date' => 'required|date|after_or_equal:today',
            'requested_time' => 'required',
            'notes' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointments::create([
            'pet_id' => $validated['pet_id'],
            'service_id' => $validated['service_id'],
            'vet_id' => null,
            'requested_date' => $validated['requested_date'],
            'requested_time' => $validated['requested_time'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Notify Admins
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {

            $admin->notify(
                new AppointmentNotification([
                    'user' => auth()->user()->fullname,
                    'action' => 'New Appointment',
                    'message' => auth()->user()->fullname . ' submitted an appointment request.'
                ])
            );
            event(new NotificationCreated(
                $admin->id,
                auth()->user()->role,
                [
                    'action' => 'New Appointment',
                    'message' => auth()->user()->fullname . ' submitted an appointment request.'
                ]
            ));
        }

        return response()->json([
            'status' => 1,
            'message' => 'Appointment request submitted successfully!',
            'appointment' => $appointment
        ]);
    }

    public function getAppointmentList()
    {
        $appointments = Appointments::with(['pets', 'service', 'vets'])
            ->whereHas('pets', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->paginate(5);

        return view('user.appointmentList', compact('appointments'));
    }
    public function cancelledStatus($id)
    {
        $appointment = Appointments::findOrFail($id);
        $appointment->status = 'cancelled';
        $appointment->save();

        return response()->json([
            'status' => 1,
            'message' => 'Appointment cancelled successfully.'
        ]);
    }

}
