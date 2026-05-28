<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class VetController extends Controller
{
    public function dashboard()
    {
        return view('vet.dashboard');
    }

    public function vetSettings()
    {
        return view('vet.settings');
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

}
