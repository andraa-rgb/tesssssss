<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    /**
     * Display welcome page with list of dosen
     */
   public function index()
{
    // Ambil dosen dengan urutan: kepala_lab dulu, lalu staf, lalu nama A-Z
    $dosens = User::whereIn('role', ['kepala_lab', 'staf'])
        ->with(['status', 'jadwals'])
        ->orderByRaw("FIELD(role, 'kepala_lab', 'staf')")
        ->orderBy('name', 'asc')
        ->get()
        ->map(function ($dosen) {
            // Generate QR SVG untuk tiap dosen (landing)
            $url = route('dosen.show', $dosen->id);

            $dosen->qr_svg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(250)
                ->margin(2)
                ->errorCorrection('H')
                ->generate($url);

            return $dosen;
        });

    return view('welcome', compact('dosens'));
     // ATAU:
        // return view('welcome', ['dosens' => $dosens]);
}


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

        // Get schedule for this week
        $jadwalMingguIni = $user->jadwals()
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Status real-time
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
