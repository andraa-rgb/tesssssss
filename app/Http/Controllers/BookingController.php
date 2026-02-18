<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReceivedMail;
use App\Mail\BookingApprovedMail;
use App\Mail\BookingRejectedMail;

class BookingController extends Controller
{
    /**
     * Tampilkan list booking untuk dosen yang login
     * View: resources/views/dosen/booking/index.blade.php
     */
    public function index()
    {
        $user = auth()->user();

        $bookings = $user->bookings()
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(15);

        return view('dosen.booking.index', compact('bookings'));
    }

    /**
     * Approve booking
     */
    public function approve(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        try {
            Mail::to($booking->email_mahasiswa)->send(new BookingApprovedMail($booking));
            $msg = 'Booking disetujui dan email notifikasi telah dikirim ke ' . $booking->email_mahasiswa;
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
            'status' => 'rejected',
            'alasan_reject' => $validated['alasan_reject'],
            'rejected_at' => now(),
        ]);

        try {
            Mail::to($booking->email_mahasiswa)->send(new BookingRejectedMail($booking));
            $msg = 'Booking ditolak dan email notifikasi telah dikirim ke ' . $booking->email_mahasiswa;
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
