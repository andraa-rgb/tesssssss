<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display welcome page with list of dosen
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['kepala_lab', 'staf'])
            ->with(['status', 'jadwals'])
            ->orderByRaw("FIELD(role, 'kepala_lab', 'staf')")
            ->orderBy('name', 'asc');

        // Filter by search text (nama / email)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $dosens = $query->get()->map(function ($dosen) {
            $url = route('dosen.show', $dosen->id);
            $dosen->qr_svg = QrCode::format('svg')
                ->size(250)
                ->margin(2)
                ->errorCorrection('H')
                ->generate($url);
            return $dosen;
        });

        /**
         * JADWAL UNTUK SLIDER HERO
         */
        $upcomingSchedules = Jadwal::with(['user', 'user.status'])
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('jam_mulai')
            ->limit(10)
            ->get();

        return view('welcome', [
            'dosens'            => $dosens,
            'upcomingSchedules' => $upcomingSchedules,
        ]);
    }

    /**
     * Display dashboard for authenticated dosen
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Get statistics
        $totalJadwal      = $user->jadwals()->count();
        $totalBooking     = $user->bookings()->count();
        $pendingBooking   = $user->bookings()->where('status', 'pending')->count();
        $approvedBooking  = $user->bookings()->where('status', 'approved')->count();

        // Get recent bookings (last 5)
        $recentBookings = $user->bookings()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Hari ini (nama hari Indonesia)
        $today = Carbon::now();
        $hariIni = $today->locale('id')->dayName;

        // Get today's schedule (jadwal rutin dari tabel jadwals)
        $todaySchedule = $user->jadwals()
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Booking approved untuk hari ini
        $todayApprovedBookings = $user->bookings()
            ->whereDate('tanggal_booking', $today->toDateString())
            ->where('status', 'approved')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Gabungkan jadwal rutin + booking approved
        $todayAllEvents = collect();

        // Tambahkan jadwal rutin
        foreach ($todaySchedule as $j) {
            $todayAllEvents->push([
                'tipe'           => 'jadwal',
                'hari'           => $j->hari,
                'jam_mulai'      => $j->jam_mulai,
                'jam_selesai'    => $j->jam_selesai,
                'kegiatan'       => $j->kegiatan,
                // kalau di jadwal kamu simpan string ruangan langsung
                'ruangan'        => $j->ruangan ?? '-',
                'ruangan_nama'   => $j->ruangan ?? '-',
                'keterangan'     => $j->keterangan,
                'nama_mahasiswa' => null,
                'nim_mahasiswa'  => null,
                'booking_id'     => null, // jadwal rutin tidak punya booking
            ]);
        }

        // Tambahkan booking approved
        foreach ($todayApprovedBookings as $b) {
            $todayAllEvents->push([
                'tipe'           => 'booking',
                'hari'           => $hariIni,
                'jam_mulai'      => $b->jam_mulai,
                'jam_selesai'    => $b->jam_selesai,
                // tampilkan ringkas keperluan
                'kegiatan'       => 'Konsultasi: ' . \Illuminate\Support\Str::limit($b->keperluan, 40),
                // ✅ AMBIL DARI KOLOM RUANGAN BOOKING, BUKAN HARDCODE
                'ruangan'        => $b->ruangan ?? 'Belum ditentukan',
                'ruangan_nama'   => $b->ruangan ?? 'Belum ditentukan',
                'keterangan'     => $b->keperluan,
                'nama_mahasiswa' => $b->nama_mahasiswa,
                'nim_mahasiswa'  => $b->nim_mahasiswa,
                // ✅ UNTUK LINK KE DETAIL BOOKING
                'booking_id'     => $b->id,
            ]);
        }

        // Urutkan berdasarkan jam_mulai
        $todayAllEvents = $todayAllEvents->sortBy('jam_mulai')->values();

        // Get schedule for this week
        $jadwalMingguIni = $user->jadwals()
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Status real-time
        $status = $user->status ?? null;

        return view('dosen.dashboard', compact(
            'totalJadwal',
            'totalBooking',
            'pendingBooking',
            'approvedBooking',
            'recentBookings',
            'todaySchedule',
            'jadwalMingguIni',
            'status',
            'todayAllEvents'
        ));
    }
}
