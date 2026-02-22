<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingApprovedMail;
use App\Mail\BookingRejectedMail;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Tampilkan list booking untuk dosen yang login
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $bookingsQuery = $user->bookings()
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_mulai', 'desc');

        if ($request->filled('status')) {
            $bookingsQuery->where('status', $request->status);
        }

        $bookings = $bookingsQuery->paginate(15)->withQueryString();

        return view('dosen.booking.index', compact('bookings'));
    }

    /**
     * Detail booking
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini.');
        }

        return view('dosen.booking.show', compact('booking'));
    }

    /**
     * Form edit booking oleh dosen
     */
    public function edit(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('dosen.booking.edit', compact('booking'));
    }

    /**
     * Update booking (tanggal, jam, ruangan, catatan_dosen)
     * Status TIDAK diubah di sini.
     */
    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'tanggal_booking' => 'required|date',
            'jam_mulai'       => 'required|date_format:H:i',
            'jam_selesai'     => 'required|date_format:H:i|after:jam_mulai',
            'ruangan'         => 'nullable|string|max:255',
            'catatan_dosen'   => 'nullable|string|max:2000',
        ]);

        $tanggal = Carbon::parse($validated['tanggal_booking']);
        $hari    = $tanggal->locale('id')->dayName;

        $conflictJadwal = $booking->user
            ->jadwals()
            ->where('hari', $hari)
            ->where(function ($q) use ($validated) {
                $q->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhere(function ($q2) use ($validated) {
                      $q2->where('jam_mulai', '<=', $validated['jam_mulai'])
                         ->where('jam_selesai', '>=', $validated['jam_selesai']);
                  });
            })
            ->exists();

        $conflictBooking = Booking::where('id', '!=', $booking->id)
            ->where('user_id', $booking->user_id)
            ->where('tanggal_booking', $validated['tanggal_booking'])
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                  ->orWhere(function ($q2) use ($validated) {
                      $q2->where('jam_mulai', '<=', $validated['jam_mulai'])
                         ->where('jam_selesai', '>=', $validated['jam_selesai']);
                  });
            })
            ->exists();

        if ($conflictJadwal || $conflictBooking) {
            return back()
                ->withInput()
                ->with('error', 'Jam yang dipilih bentrok dengan jadwal/booking lain. Silakan sesuaikan lagi.');
        }

        $booking->update($validated);

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil diperbarui.');
    }

    /**
     * Approve booking (wajib isi ruangan, catatan opsional)
     */
    public function approve(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi input dari modal approve
        $validated = $request->validate([
            'ruangan'       => 'required|string|min:3|max:255',
            'catatan_dosen' => 'nullable|string|max:2000',
        ]);

        $tanggal = Carbon::parse($booking->tanggal_booking);
        $hari    = $tanggal->locale('id')->dayName;

        // Cek bentrok dengan jadwal rutin
        $conflictJadwal = $booking->user
            ->jadwals()
            ->where('hari', $hari)
            ->where(function ($q) use ($booking) {
                $q->whereBetween('jam_mulai', [$booking->jam_mulai, $booking->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$booking->jam_mulai, $booking->jam_selesai])
                  ->orWhere(function ($q2) use ($booking) {
                      $q2->where('jam_mulai', '<=', $booking->jam_mulai)
                         ->where('jam_selesai', '>=', $booking->jam_selesai);
                  });
            })
            ->exists();

        // Cek bentrok dengan booking lain yang sudah approved
        $conflictBooking = Booking::where('id', '!=', $booking->id)
            ->where('user_id', $booking->user_id)
            ->where('tanggal_booking', $booking->tanggal_booking)
            ->where('status', 'approved')
            ->where(function ($q) use ($booking) {
                $q->whereBetween('jam_mulai', [$booking->jam_mulai, $booking->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$booking->jam_mulai, $booking->jam_selesai])
                  ->orWhere(function ($q2) use ($booking) {
                      $q2->where('jam_mulai', '<=', $booking->jam_mulai)
                         ->where('jam_selesai', '>=', $booking->jam_selesai);
                  });
            })
            ->exists();

        if ($conflictJadwal || $conflictBooking) {
            return back()->with('error', 'Jadwal bentrok! Gunakan tombol Edit untuk mengubah waktu terlebih dahulu.');
        }

        // Update status + ruangan + catatan dosen
        $booking->update([
            'status'        => 'approved',
            'approved_at'   => now(),
            'ruangan'       => $validated['ruangan'],
            'catatan_dosen' => $validated['catatan_dosen'] ?? $booking->catatan_dosen,
        ]);

        try {
            Mail::to($booking->email_mahasiswa)->send(new BookingApprovedMail($booking));
            $msg = 'Booking disetujui dan email notifikasi telah dikirim ke '.$booking->email_mahasiswa;
        } catch (\Exception $e) {
            \Log::error('Email approval gagal: '.$e->getMessage());
            $msg = 'Booking disetujui, tetapi email notifikasi gagal dikirim.';
        }

        return back()->with('success', $msg);
    }

    /**
     * Reject booking
     */
    public function reject(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'alasan_reject' => 'required|string|min:10|max:500',
        ]);

        $booking->update([
            'status'        => 'rejected',
            'alasan_reject' => $validated['alasan_reject'],
            'rejected_at'   => now(),
        ]);

        try {
            Mail::to($booking->email_mahasiswa)->send(new BookingRejectedMail($booking));
            $msg = 'Booking ditolak dan email notifikasi telah dikirim ke '.$booking->email_mahasiswa;
        } catch (\Exception $e) {
            \Log::error('Email rejection gagal: '.$e->getMessage());
            $msg = 'Booking ditolak, tetapi email notifikasi gagal dikirim.';
        }

        return back()->with('success', $msg);
    }

    /**
     * Hapus booking
     */
    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->delete();

        return back()->with('success', 'Booking berhasil dihapus.');
    }
}
