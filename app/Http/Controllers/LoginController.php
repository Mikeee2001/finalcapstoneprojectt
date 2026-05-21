<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }
    public function showLoginForm()
    {
        return view('signin');
    }

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Invalid email or password.');
        }

        $user = Auth::user();

        // Block if not verified
        if (!$user->email_verified_at) {
            Auth::logout();
            return back()->with('error', 'Please verify your email before logging in.');
        }

        // Role-based redirect
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'user':
                // ✅ Allow login once email is verified
                return redirect()->route('user.dashboard');

            default:
                Auth::logout();
                return redirect()->route('signin')->with('error', 'Unauthorized access.');
        }
    }

}

