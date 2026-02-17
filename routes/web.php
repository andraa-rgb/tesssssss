<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DosenPublicController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Tidak perlu login)
|--------------------------------------------------------------------------
*/

// Home/Welcome
Route::get('/', [HomeController::class, 'index'])->name('home');

// Detail Dosen (Publik bisa akses)
Route::get('/dosen/{user}', [DosenPublicController::class, 'show'])->name('dosen.show');
Route::post('/dosen/{user}/booking', [DosenPublicController::class, 'storeBooking'])->name('dosen.booking.store');

// API untuk AJAX (Publik)
Route::get('/api/jadwal/{user}', [DosenPublicController::class, 'apiJadwal'])->name('api.jadwal');
Route::get('/api/status/{user}', [DosenPublicController::class, 'apiStatus'])->name('api.status');

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Protected Routes (Perlu Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Jadwal Management (CRUD)
    Route::resource('jadwal', JadwalController::class)->except(['show']);

    // Booking Management
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking/{booking}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::post('/booking/{booking}/reject', [BookingController::class, 'reject'])->name('booking.reject');

    // Status Update (Manual/IoT)
    Route::post('/api/status/update', [StatusController::class, 'update'])->name('api.status.update');
});
