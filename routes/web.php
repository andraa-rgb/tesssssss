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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;

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

// API QR Code (untuk modal di landing page) - HANYA SATU ROUTE
Route::get('/api/qrcode/{id}', function($id) {
    try {
        $user = User::findOrFail($id);
        $url = route('dosen.show', $user->id);
        
        $qrCode = QrCode::size(250)
                        ->style('round')
                        ->eye('circle')
                        ->margin(2)
                        ->errorCorrection('H')
                        ->generate($url);
        
        return response($qrCode, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'public, max-age=3600');
            
    } catch (\Exception $e) {
        \Log::error('QR Code generation failed: ' . $e->getMessage());
        
        return response()->json([
            'error' => 'QR Code tidak dapat dibuat',
            'message' => $e->getMessage(),
            'user_id' => $id
        ], 500);
    }
})->name('api.qrcode');

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

    // Dashboard Dosen
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Profil Dosen
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Password Update
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    
    // QR Code Download
    Route::get('/profile/qrcode/download', [ProfileController::class, 'downloadQrCode'])
        ->name('profile.qrcode.download');

    // Jadwal Dosen (CRUD)
    Route::resource('jadwal', JadwalController::class)->except(['show']);

    // Booking Dosen
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking/{booking}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::post('/booking/{booking}/reject', [BookingController::class, 'reject'])->name('booking.reject');

    // Update Status Real-time
    Route::post('/api/status/update', [StatusController::class, 'update'])->name('api.status.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Perlu Login + Role Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kelola akun dosen
    Route::get('/dosen', [AdminDosenController::class, 'index'])->name('dosen.index');
    Route::get('/dosen/create', [AdminDosenController::class, 'create'])->name('dosen.create');
    Route::post('/dosen', [AdminDosenController::class, 'store'])->name('dosen.store');
    Route::delete('/dosen/{user}', [AdminDosenController::class, 'destroy'])->name('dosen.destroy');
});
