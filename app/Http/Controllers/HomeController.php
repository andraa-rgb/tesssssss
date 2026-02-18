<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display welcome page with list of dosen
     */
       public function index()
    {
        // ambil hanya dosen (role kepala_lab & staf) + relasi yang dibutuhkan
        $dosens = User::whereIn('role', ['kepala_lab', 'staf'])
            ->with(['status', 'jadwals'])
            ->orderBy('name', 'asc')
            ->get();

        return view('welcome', compact('dosens'));
        // ATAU:
        // return view('welcome', ['dosens' => $dosens]);
    }

    /**
     * Display dashboard for authenticated dosen
     */

    /**
     * Display dashboard for authenticated dosen
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // Get statistics
        $totalJadwal     = $user->jadwals()->count();
        $totalBooking    = $user->bookings()->count();
        $pendingBooking  = $user->bookings()->where('status', 'pending')->count();
        $approvedBooking = $user->bookings()->where('status', 'approved')->count();
        
        // Get recent bookings (last 5)
        $recentBookings = $user->bookings()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get today's schedule
        $todaySchedule = $user->jadwals()
            ->where('hari', now()->locale('id')->dayName)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Get schedule for this week (kalau kamu simpan semua hari di jadwals)
        $jadwalMingguIni = $user->jadwals()
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Status real-time (kalau kamu punya tabel status terpisah,
        // misal model Status dengan kolom user_id, status)
        // Jika belum punya model, sementara bisa pakai null
        $status = $user->status ?? null;

        return view('dashboard', compact(
            'totalJadwal',
            'totalBooking',
            'pendingBooking',
            'approvedBooking',
            'recentBookings',
            'todaySchedule',
            'jadwalMingguIni',
            'status'
        ));
    }
}
