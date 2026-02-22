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

// Home/Welcome - Menampilkan daftar dosen
Route::get('/', [HomeController::class, 'index'])->name('home');

// Download QR Code PNG (dipakai landing page & profil dosen)
Route::get('/dosen/{user}/qrcode/download', [DosenPublicController::class, 'downloadQr'])
    ->name('dosen.qrcode.download');

/*
|--------------------------------------------------------------------------
| API Public untuk AJAX (Real-time data)
|--------------------------------------------------------------------------
*/

Route::prefix('api')->name('api.')->group(function () {
    // Get jadwal dosen
    Route::get('/jadwal/{user}', [DosenPublicController::class, 'apiJadwal'])->name('jadwal');

    // Get status ketersediaan dosen
    Route::get('/status/{user}', [DosenPublicController::class, 'apiStatus'])->name('status');

    // Generate QR Code SVG (untuk embed di halaman)
    Route::get('/qrcode/{id}', function ($id) {
        try {
            if (!extension_loaded('gd') && !extension_loaded('imagick')) {
                return response()->json([
                    'error' => 'GD atau Imagick extension tidak tersedia di server',
                ], 500);
            }

            $user = User::findOrFail($id);
            $url  = route('dosen.show', $user->id);

            $qrCode = QrCode::format('svg')
                ->size(250)
                ->style('round')
                ->eye('circle')
                ->margin(2)
                ->errorCorrection('H')
                ->generate($url);

            return response($qrCode, 200)
                ->header('Content-Type', 'image/svg+xml')
                ->header('Cache-Control', 'public, max-age=86400')
                ->header('Access-Control-Allow-Origin', '*');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error'   => 'User tidak ditemukan',
                'user_id' => $id,
            ], 404);

        } catch (\Exception $e) {
            \Log::error('QR Code generation failed', [
                'user_id' => $id,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error'   => 'QR Code tidak dapat dibuat',
                'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                'user_id' => $id,
            ], 500);
        }
    })->name('qrcode');
});

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

Route::middleware(['auth', 'verified'])->group(function () {

    // DASHBOARD DOSEN
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // PROFILE MANAGEMENT
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    // JADWAL MANAGEMENT (CRUD)
    Route::resource('jadwal', JadwalController::class)->except(['show']);

    // ✅ BOOKING MANAGEMENT (UNTUK DOSEN YANG LOGIN)
    // PENTING: Harus di atas route /dosen/{user} supaya tidak ketabrak
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        
        // ✅ TAMBAHKAN INI - Detail booking (harus sebelum {booking}/edit)
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        
        Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [BookingController::class, 'update'])->name('update');
        Route::post('/{booking}/approve', [BookingController::class, 'approve'])->name('approve');
        Route::post('/{booking}/reject', [BookingController::class, 'reject'])->name('reject');
        Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
    });

    // STATUS REAL-TIME UPDATE
    Route::post('/api/status/update', [StatusController::class, 'update'])->name('api.status.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Perlu Login + Role Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ADMIN DASHBOARD
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // KELOLA DOSEN
        Route::prefix('dosen')->name('dosen.')->group(function () {
            Route::get('/', [AdminDosenController::class, 'index'])->name('index');
            Route::get('/create', [AdminDosenController::class, 'create'])->name('create');
            Route::post('/', [AdminDosenController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [AdminDosenController::class, 'edit'])->name('edit');
            Route::put('/{user}', [AdminDosenController::class, 'update'])->name('update');
            Route::delete('/{user}', [AdminDosenController::class, 'destroy'])->name('destroy');
        });

        // KELOLA BOOKING (Admin view all)
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'allBookings'])->name('index');
            Route::delete('/{booking}', [AdminDashboardController::class, 'deleteBooking'])->name('destroy');
        });

        // REPORTS & STATISTICS
        Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    });

/*
|--------------------------------------------------------------------------
| Public Dosen Routes
| PENTING: Harus di paling bawah karena menggunakan wildcard {user}
|--------------------------------------------------------------------------
*/

// Detail Dosen (Publik) - Bisa diakses tanpa login
// Route ini menggunakan {user} wildcard, jadi harus di bawah semua route /dosen/* yang spesifik
Route::get('/dosen/{user}', [DosenPublicController::class, 'show'])->name('dosen.show');
Route::post('/dosen/{user}/booking', [DosenPublicController::class, 'storeBooking'])->name('dosen.booking.store');
