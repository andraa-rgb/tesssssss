<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        // Pastikan hanya admin yang bisa akses
        $this->middleware(function ($request, $next) {
            if (! auth()->check() || auth()->user()->role !== 'admin') {
                abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $totalDosen   = User::whereIn('role', ['kepala_lab', 'staf'])->count();
        $totalJadwal  = Jadwal::count();
        $bookingAktif = Booking::whereIn('status', ['pending', 'approved'])->count();

        $dosens = User::whereIn('role', ['kepala_lab', 'staf'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalDosen',
            'totalJadwal',
            'bookingAktif',
            'dosens'
        ));
    }
}
