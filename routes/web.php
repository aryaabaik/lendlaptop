<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect root sesuai status login
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

// --- New Central Dashboard Route for Authenticated Users ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // Assuming your User model has an 'isAdmin()' method or similar role check
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard'); // This is the generic 'dashboard' route name for navigation
});
// --- End New Central Dashboard Route ---
// Auth routes (dari Breeze, jangan dihapus)
require __DIR__.'/auth.php';

// Redirect /dashboard sesuai role (Breeze compatibility)
Route::get('/dashboard', function () {
    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->middleware(['auth'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\User\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [App\Http\Controllers\User\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [App\Http\Controllers\User\NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',          [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('laptops',        Admin\LaptopController::class);
    Route::resource('categories',     Admin\CategoryController::class);
    Route::resource('borrowings',     Admin\BorrowingController::class);
    Route::patch('borrowings/{borrowing}/approve', [Admin\BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::patch('borrowings/{borrowing}/reject',  [Admin\BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::resource('returns',        Admin\ReturnController::class);
    Route::resource('maintenances',   Admin\MaintenanceController::class);
    Route::resource('users',          Admin\UserController::class);
    Route::get('/reports',            [Admin\ReportController::class, 'index'])->name('reports.index');
});

// User routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard',        [User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laptops',          [User\LaptopController::class, 'index'])->name('laptops.index');
    Route::get('/laptops/{laptop}', [User\LaptopController::class, 'show'])->name('laptops.show');
    Route::resource('borrowings',   User\BorrowingController::class)->only(['index','store','show','destroy']);
    Route::get('/history',          [User\HistoryController::class, 'index'])->name('history');
    Route::get('/profile',          [User\ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile',        [User\ProfileController::class, 'update'])->name('profile.update');
});