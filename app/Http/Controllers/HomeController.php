<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Halaman Home/Welcome (Publik)
     */
    public function index()
    {
        // Ambil 3 dosen untuk ditampilkan di home
        // Bisa disesuaikan: semua dosen, atau filter tertentu
        $dosens = User::whereIn('role', ['kepala_lab', 'staf'])
            ->with(['status', 'jadwals', 'bookings'])
            ->get();

        return view('welcome', compact('dosens'));
    }

    /**
     * Dashboard Dosen (Protected)
     */
    public function dashboard()
    {
        $user = auth()->user();

        $totalJadwal = $user->jadwals()->count();
        $pendingBooking = $user->bookings()->where('status', 'pending')->count();
        $status = $user->status;

        $jadwalMingguIni = $user->jadwals()
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('jam_mulai')
            ->get();

        return view('dosen.dashboard', compact(
            'totalJadwal',
            'pendingBooking',
            'status',
            'jadwalMingguIni'
        ));
    }
}
