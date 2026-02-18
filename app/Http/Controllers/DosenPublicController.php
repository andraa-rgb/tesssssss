<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Mail\BookingReceivedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class DosenPublicController extends Controller
{
    /**
     * Tampilkan profil dan jadwal dosen (publik)
     */
    public function show(User $user)
    {
        // load relasi yang dipakai di view (status & jadwals)
        $user->load(['status', 'jadwals']);

        // jadwal mingguan
        $jadwals = $user->jadwals()
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai', 'asc')
            ->get()
            ->groupBy('hari');

        // status saat ini
        $now         = Carbon::now('Asia/Makassar');
        $dayName     = $now->locale('id')->dayName;
        $currentTime = $now->format('H:i:s');

        $currentSchedule = $user->jadwals()
            ->where('hari', $dayName)
            ->where('jam_mulai', '<=', $currentTime)
            ->where('jam_selesai', '>=', $currentTime)
            ->first();

        // === TAMBAHAN: QR CODE UNTUK HALAMAN PUBLIK DOSEN INI ===
        $qrCodeUrl = route('dosen.show', $user->id);

        $qrCodeSvg = QrCode::format('svg')
            ->size(250)
            ->style('round')
            ->eye('circle')
            ->margin(2)
            ->errorCorrection('H')
            ->generate($qrCodeUrl);

        return view('dosen.show', [
            'dosen'           => $user,
            'jadwals'         => $jadwals,
            'currentSchedule' => $currentSchedule,
            'qrCodeUrl'       => $qrCodeUrl,
            'qrCodeSvg'       => $qrCodeSvg,
        ]);
    }

    /**
     * Simpan booking dari mahasiswa (publik)
     */
    public function storeBooking(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_mahasiswa'   => 'required|string|max:255',
            'nim_mahasiswa'    => 'nullable|string|max:50',
            'email_mahasiswa'  => 'required|email|max:255',
            'tanggal_booking'  => 'required|date|after_or_equal:today',
            'jam_mulai'        => 'required|date_format:H:i',
            'jam_selesai'      => 'required|date_format:H:i|after:jam_mulai',
            'keperluan'        => 'required|string|min:10|max:1000',
        ], [
            'nama_mahasiswa.required'   => 'Nama mahasiswa wajib diisi.',
            'email_mahasiswa.required'  => 'Email mahasiswa wajib diisi.',
            'email_mahasiswa.email'     => 'Format email tidak valid.',
            'tanggal_booking.required'  => 'Tanggal booking wajib dipilih.',
            'tanggal_booking.after_or_equal' => 'Tanggal booking tidak boleh kurang dari hari ini.',
            'jam_mulai.required'       => 'Jam mulai wajib dipilih.',
            'jam_selesai.required'     => 'Jam selesai wajib dipilih.',
            'jam_selesai.after'        => 'Jam selesai harus setelah jam mulai.',
            'keperluan.required'       => 'Keperluan konsultasi wajib diisi.',
            'keperluan.min'            => 'Keperluan minimal 10 karakter.',
        ]);

        $conflict = Booking::where('user_id', $user->id)
            ->where('tanggal_booking', $validated['tanggal_booking'])
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                      ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                      ->orWhere(function ($q) use ($validated) {
                          $q->where('jam_mulai', '<=', $validated['jam_mulai'])
                            ->where('jam_selesai', '>=', $validated['jam_selesai']);
                      });
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal yang Anda pilih sudah dibooking oleh mahasiswa lain. Silakan pilih waktu lain.');
        }

        $validated['user_id'] = $user->id;
        $validated['status']  = 'pending';

        $booking = Booking::create($validated);

        try {
            Mail::to($booking->email_mahasiswa)->send(new BookingReceivedMail($booking));
            $message = 'Booking berhasil dikirim! Email konfirmasi telah dikirim ke ' . $booking->email_mahasiswa;
        } catch (\Exception $e) {
            Log::error('Email gagal terkirim', [
                'booking_id' => $booking->id,
                'error'      => $e->getMessage(),
            ]);

            $message = 'Booking berhasil dikirim! Namun email konfirmasi gagal dikirim. Silakan cek status booking Anda nanti.';
        }

        return redirect()
            ->route('dosen.show', $user)
            ->with('success', $message);
    }

    /**
     * API: Get jadwal dosen (untuk AJAX)
     */
    public function apiJadwal(User $user)
    {
        $jadwals = $user->jadwals()
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $jadwals,
        ]);
    }

    /**
     * API: Get status ketersediaan dosen (untuk AJAX)
     */
    public function apiStatus(User $user)
    {
        $now         = Carbon::now('Asia/Makassar');
        $dayName     = $now->locale('id')->dayName;
        $currentTime = $now->format('H:i:s');

        $currentSchedule = $user->jadwals()
            ->where('hari', $dayName)
            ->where('jam_mulai', '<=', $currentTime)
            ->where('jam_selesai', '>=', $currentTime)
            ->first();

        $isAvailable = $currentSchedule !== null;

        return response()->json([
            'success'          => true,
            'available'        => $isAvailable,
            'current_schedule' => $currentSchedule,
            'current_time'     => $now->format('H:i:s'),
            'current_day'      => $dayName,
        ]);
    }

    /**
     * Download QR Code PNG untuk profil dosen
     * (dipakai di landing page & di profil dosen)
     */
    public function downloadQr(User $user)
{
    $url = route('dosen.show', $user->id);

    // generate raw PNG binary
    $pngData = QrCode::format('png')
        ->size(500)
        ->margin(2)
        ->errorCorrection('H')
        ->generate($url);

    $filename = 'qrcode-' . str_replace(' ', '-', strtolower($user->name)) . '.png';

    return response($pngData, 200, [
        'Content-Type'              => 'image/png',
        'Content-Disposition'       => 'attachment; filename="'.$filename.'"',
        'Content-Length'            => strlen($pngData),
        'X-Content-Type-Options'    => 'nosniff',
        'Cache-Control'             => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma'                    => 'no-cache',
    ]);
}

public function apiQrSvg(User $user)
{
    $url = route('dosen.show', $user->id);

    $svg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
        ->size(500)
        ->margin(2)
        ->errorCorrection('H')
        ->generate($url);

    return response($svg, 200, [
        'Content-Type' => 'image/svg+xml; charset=utf-8',
    ]);
}


}
