<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
        $users = User::simplePaginate(10);
        return view('admin.users', compact('users'));
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


}
