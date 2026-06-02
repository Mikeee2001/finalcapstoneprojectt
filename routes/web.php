<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VetController;
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
    Route::get('/vets/fetch', [AdminController::class, 'fetchVets'])->name('admin.vets.fetch');
    Route::post('/create/vet', [AdminController::class, 'createVet'])->name('admin.vet.create');
    Route::delete('/vets/delete/{id}', [AdminController::class, 'deleteVet']);
    Route::get('/vets/show/{id}', [AdminController::class, 'showVet']);
    Route::post('/vets/update-status', [AdminController::class, 'toggleVetStatus'])->name('admin.vets.updateStatus');
    Route::put('/vets/update/{id}', [AdminController::class, 'updateVet'])->name('admin.vets.update');
    Route::get('/services', [AdminController::class, 'categories'])->name('admin.services');
    Route::post('/services/add', [AdminController::class, 'addService'])->name('admin.add.services');
    Route::post('/service/toggle-status/{id}', [AdminController::class, 'toggleServiceStatus'])->name('admin.toggle.service.status');
    Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('/appointments/{id}/status', [NotificationController::class, 'updateStatus'])->name('admin.appointments.updateStatus');
    Route::get('/appointments-all/fetch', [AdminController::class, 'fetchAppointmentsAll'])->name('admin.all.appointments.fetch');
    Route::post('/appointments/{id}/reschedule', [NotificationController::class, 'reschedule'])->name('admin.appointments.reschedule');
    Route::get('/appointments/calendar', [AdminController::class, 'calendarEvents'])->name('admin.appointments.calendar');
});

Route::prefix('vet')->middleware(['auth', 'checkRole:vet'])->group(function () {
    Route::get('/dashboard', [VetController::class, 'dashboard'])->name('vet.dashboard');
    Route::get('/settings', [VetController::class, 'vetSettings'])->name('vet.settings');
    Route::post('/settings/update', [VetController::class, 'updateVet'])->name('vet.settings.update');
    Route::post('/settings/change-password', [VetController::class, 'updateVetPassword'])->name('vet.settings.change.password');
    Route::get('notifications', [NotificationController::class, 'index'])->name('vet.notifications.index');


});

Route::prefix('user')->middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'getuserDashboard'])->name('user.dashboard');
    Route::get('/settings', [UserController::class, 'userSettings'])->name('user.settings');
    Route::post('/settings/update', [UserController::class, 'updateUser'])->name('user.update');
    Route::post('/settings/password', [UserController::class, 'updateUserPassword'])->name('user.update.password');
    Route::get('/pets', [UserController::class, 'petList'])->name('user.pets');
    Route::post('/pets/add', [UserController::class, 'createPet'])->name('user.pets.add');
    Route::delete('/pets/delete/{id}', [UserController::class, 'deletePet'])->name('user.pets.delete');
    Route::get('/appointments', [UserController::class, 'getAppointmentForm'])->name('user.appointmentForm');
    Route::post('/appointment-store', [UserController::class, 'storeAppointment'])->name('user.appointment.store');
    Route::get('notifications', [NotificationController::class, 'index'])->name('user.notifications.index');
    Route::get('/appointments/fetch', [UserController::class, 'getAppointmentList'])->name('user.appointments.fetch');
    Route::post('/appointments/{id}/status', [NotificationController::class, 'updateStatus'])->name('user.appointments.updateStatus');

});

Route::get('/vet/assigned-appointments', [VetController::class, 'getAssignedAppointments'])->name('vet.assigned-appointments');

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

Route::get('/notifications/unread-count', function () {
    return response()->json([
        'count' => auth()->user()->unreadNotifications()->count()
    ]);
});
Route::post('/notifications/mark-as-read', function () {
    auth()->user()->unreadNotifications->markAsRead();

    return response()->json(['success' => true]);
});


// Logouts Routes
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
