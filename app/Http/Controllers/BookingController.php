<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Booking::where('user_id', auth()->id())
            ->latest();

        if ($status && in_array($status, ['pending','approved','rejected'])) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(10);

        return view('dosen.booking.index', compact('bookings','status'));
    }

    public function approve(Booking $booking)
    {
        $this->authorizeOwner($booking);

        $booking->update([
            'status' => 'approved',
            'alasan_reject' => null,
        ]);

        return back()->with('success','Booking disetujui.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $this->authorizeOwner($booking);

        $data = $request->validate([
            'alasan_reject' => 'required|string',
        ]);

        $booking->update([
            'status' => 'rejected',
            'alasan_reject' => $data['alasan_reject'],
        ]);

        return back()->with('success','Booking ditolak.');
    }

    protected function authorizeOwner(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);
    }
}
