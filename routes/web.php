<?php

// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect()->route('login');
});

// Redirect after login based on role
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->isUser()) {
        return redirect()->route('user.dashboard');
    }
    
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes - Tambahkan middleware admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'userCreate'])->name('users.create');
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('users.show')->withTrashed();
    Route::get('/users/{user}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'userDestroy'])->name('users.destroy');
    Route::get('/users/{user}/delete-photo', [AdminController::class, 'userDeletePhoto'])->name('users.delete-photo'); // Route baru
    
        
    // Payment Management
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::get('/payments/all', [AdminController::class, 'paymentsAll'])->name('payments.all');
    Route::get('/payments/{payment}', [AdminController::class, 'paymentShow'])->name('payments.show');
    Route::patch('/payments/{payment}/verify', [AdminController::class, 'paymentVerify'])->name('payments.verify');
    
    // Complaint Management
    Route::get('/complaints', [AdminController::class, 'complaints'])->name('complaints');
    Route::get('/complaints/all', [AdminController::class, 'complaintsAll'])->name('complaints.all');
    Route::get('/complaints/{complaint}', [AdminController::class, 'complaintShow'])->name('complaints.show');
    Route::patch('/complaints/{complaint}', [AdminController::class, 'complaintUpdate'])->name('complaints.update');
    Route::delete('/complaints/{complaint}', [AdminController::class, 'complaintDestroy'])->name('complaints.destroy');

    // Room Management
    Route::delete('/rooms/{room}/photos/{index}', [RoomController::class, 'deletePhoto'])->name('rooms.delete-photo');
    Route::resource('rooms', RoomController::class);

    // Dorm Settings
    Route::get('/settings', [AdminController::class, 'dormSettings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'dormSettingsUpdate'])->name('settings.update');
});

// User Routes - Tambahkan middleware user
Route::prefix('user')->name('user.')->middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    //Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    // Dorm Info
    Route::get('/dorm-info', [UserController::class, 'dormInfo'])->name('dorm-info');
    // Payment Management
    Route::get('/payments', [UserController::class, 'payments'])->name('payments');
    Route::get('/payments/create', [UserController::class, 'paymentCreate'])->name('payments.create');
    Route::post('/payments', [UserController::class, 'paymentStore'])->name('payments.store');
    Route::get('/payments/{payment}', [UserController::class, 'paymentShow'])->name('payments.show');
    
    // Complaint Management - Private
    Route::get('/complaints', [UserController::class, 'complaints'])->name('complaints');
    Route::get('/complaints/create', [UserController::class, 'complaintCreate'])->name('complaints.create');
    Route::post('/complaints', [UserController::class, 'complaintStore'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [UserController::class, 'complaintShow'])->name('complaints.show');
    
    // Public Complaints - New Routes
    Route::get('/public-complaints', [UserController::class, 'publicComplaints'])->name('public-complaints');
    Route::get('/public-complaints/{complaint}', [UserController::class, 'publicComplaintShow'])->name('public-complaint-show');

    
    
    
});
require __DIR__.'/auth.php';