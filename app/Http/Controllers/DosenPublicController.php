<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DosenPublicController extends Controller
{
    /**
     * Tampilkan detail profil dosen (publik)
     */
    public function show(User $user)
    {
        // Load relasi dengan ordering
        $user->load([
            'jadwals' => function ($q) {
                $q->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
                  ->orderBy('jam_mulai');
            }, 
            'status'
        ]);

        // Rename variable untuk konsistensi dengan view
        $dosen = $user;

        // Return ke view baru yang sudah dibuat
        return view('dosen.show', compact('dosen'));
    }

    /**
     * Store booking konsultasi dari mahasiswa
     */
    public function storeBooking(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_mahasiswa'   => 'required|string|max:255',
            'nim_mahasiswa'    => 'nullable|string|max:50',
            'email_mahasiswa'  => 'required|email',
            'tanggal_booking'  => 'required|date|after_or_equal:today',
            'jam_mulai'        => 'required',
            'jam_selesai'      => 'required|after:jam_mulai',
            'keperluan'        => 'required|string|min:10',
        ], [
            'tanggal_booking.after_or_equal' => 'Tanggal booking tidak boleh kurang dari hari ini.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
            'keperluan.min' => 'Keperluan minimal 10 karakter.',
        ]);

        // Tambahkan user_id dan status default
        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';

        // Create booking
        Booking::create($validated);

        return redirect()
            ->route('dosen.show', $user)
            ->with('success', 'Booking konsultasi berhasil dikirim! Menunggu persetujuan dari ' . $user->name . '.');
    }

    /**
     * API: Get jadwal dosen (untuk AJAX)
     */
    public function apiJadwal(User $user, Request $request)
    {
        $hari = $request->query('hari');

        $query = $user->jadwals()->orderBy('jam_mulai');

        if ($hari) {
            $query->where('hari', $hari);
        }

        return response()->json($query->get());
    }

    /**
     * API: Get status real-time dosen (untuk AJAX)
     */
    public function apiStatus(User $user)
    {
        return response()->json([
            'status' => optional($user->status)->status ?? 'Tidak Ada',
            'updated_at_iot' => optional($user->status)->updated_at_iot,
            'updated_at' => optional($user->status)->updated_at,
        ]);
    }

    /**
     * API: Generate QR Code untuk dosen
     */
    public function apiQrCode($id)
    {
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
    }
}
