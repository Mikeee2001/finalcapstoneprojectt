<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmailMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SignupController extends Controller
{
    public function getSignupForm()
    {
        return view('signup');
    }
    public function signup(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        // generate token
        $token = Str::random(64);

        $user->email_verification_token = $token;
        $user->save();

        // signed URL (expires in 60 minutes)
        $url = URL::temporarySignedRoute(
            'verification.verify.custom',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
                'token' => $token,
            ]
        );

        Mail::to($user->email)->send(new VerifyEmailMail($user, $url));

        return redirect()->route('signin')
            ->with('success', 'Account created! Please verify your email.');
    }
}
