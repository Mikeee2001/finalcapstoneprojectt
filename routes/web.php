<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SignupController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'landingpage'])->name('welcome');

Route::get('/signin', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/signup', [SignupController::class, 'getSignupForm'])->name('signupForm');
Route::post('/signup', [SignupController::class, 'signup'])->name('signup');
Route::post('/signin', [LoginController::class, 'signin'])->name('signin');


Route::prefix('admin')->middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'userList'])->name('admin.users');
    Route::patch('/users/{id}/toggle', [AdminController::class, 'toggleStatus'])->name('admin.users.toggle');
    Route::delete('/users/delete/{id}', [AdminController::class, 'delete'])->name('admin.users.delete');
    Route::post('/create/user', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::get('/users/fetch', [AdminController::class, 'fetch'])->name('admin.users.fetch');
    Route::get('/users/show/{id}', [AdminController::class, 'show']);
    Route::post('/settings/update', [AdminController::class, 'update'])->name('admin.update');
    Route::post('/settings/password', [AdminController::class, 'updatePassword'])->name('admin.update.password');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
});




Route::get('/email/verify/custom/{id}/{hash}', function ($id, $hash, Request $request) {

    $user = User::findOrFail($id);

    if (!hash_equals($hash, sha1($user->email))) {
        abort(403);
    }

    if ($user->email_verification_token !== $request->token) {
        abort(403);
    }

    $user->email_verified_at = now();
    $user->email_verification_token = null;
    $user->save();

    return redirect('/signin')
        ->with('success', 'Email verified successfully!');
})->name('verification.verify.custom');


// Logouts Routes
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
