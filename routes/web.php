<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DosenPublicController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminDosenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Tidak perlu login)
|--------------------------------------------------------------------------
*/

// Home/Welcome
Route::get('/', [HomeController::class, 'index'])->name('home');

// Detail Dosen (Publik)
Route::get('/dosen/{user}', [DosenPublicController::class, 'show'])->name('dosen.show');
Route::post('/dosen/{user}/booking', [DosenPublicController::class, 'storeBooking'])->name('dosen.booking.store');

// API publik (AJAX)
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

    /*
    |-----------------------------------------
    | Dashboard Dosen (non-admin)
    |-----------------------------------------
    |
    | Jika ingin memisahkan admin & dosen via middleware,
    | bisa tambahkan middleware role di sini nanti.
    */

    Route::get('/dashboard', [HomeController::class, 'dashboard'])
        ->name('dashboard');
        // ->middleware('can:is-dosen'); // opsional, kalau sudah pakai Gate/Policy

    /*
    |-----------------------------------------
    | Profil Dosen
    |-----------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    /*
    |-----------------------------------------
    | Jadwal Dosen (CRUD)
    |-----------------------------------------
    */

    Route::resource('jadwal', JadwalController::class)->except(['show']);

    /*
    |-----------------------------------------
    | Booking Dosen
    |-----------------------------------------
    */

    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking/{booking}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::post('/booking/{booking}/reject', [BookingController::class, 'reject'])->name('booking.reject');

    /*
    |-----------------------------------------
    | Update Status Real-time
    |-----------------------------------------
    */

    Route::post('/api/status/update', [StatusController::class, 'update'])->name('api.status.update');

});

/*
|--------------------------------------------------------------------------
| Admin Routes (Perlu Login + Role Admin)
|--------------------------------------------------------------------------
|
| Admin punya dashboard dan menu kelola akun dosen.
| Akses dibatasi di dalam controller (cek role admin di __construct),
| dan bisa ditambah middleware khusus kalau sudah dibuat.
|
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    // Kelola akun dosen
    Route::get('/dosen', [AdminDosenController::class, 'index'])->name('dosen.index');
    Route::get('/dosen/create', [AdminDosenController::class, 'create'])->name('dosen.create');
    Route::post('/dosen', [AdminDosenController::class, 'store'])->name('dosen.store');
    Route::delete('/dosen/{user}', [AdminDosenController::class, 'destroy'])->name('dosen.destroy');

    // Kalau nanti mau edit/update:
    // Route::get('/dosen/{user}/edit', [AdminDosenController::class, 'edit'])->name('dosen.edit');
    // Route::put('/dosen/{user}', [AdminDosenController::class, 'update'])->name('dosen.update');
});
