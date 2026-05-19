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
});