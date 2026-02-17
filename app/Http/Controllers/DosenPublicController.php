<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class DosenPublicController extends Controller
{
    public function show(User $user)
    {
        $user->load(['jadwals' => function ($q) {
            $q->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat')")
              ->orderBy('jam_mulai');
        }, 'status']);

        return view('jadwal.detail', compact('user'));
    }

    public function storeBooking(Request $request, User $user)
    {
        $data = $request->validate([
            'nama_mahasiswa'   => 'required|string|max:255',
            'email_mahasiswa'  => 'required|email',
            'nim_mahasiswa'    => 'nullable|string|max:50',
            'tanggal_booking'  => 'required|date|after:today',
            'jam_mulai'        => 'required',
            'jam_selesai'      => 'required|after:jam_mulai',
            'keperluan'        => 'required|string',
        ]);

        $data['user_id'] = $user->id;

        Booking::create($data);

        return back()->with('success', 'Booking konsultasi berhasil dikirim, tunggu persetujuan dosen.');
    }

    public function apiJadwal(User $user, Request $request)
    {
        $hari = $request->query('hari');

        $query = $user->jadwals()->orderBy('jam_mulai');

        if ($hari) {
            $query->where('hari', $hari);
        }

        return response()->json($query->get());
    }

    public function apiStatus(User $user)
    {
        return response()->json([
            'status' => optional($user->status)->status ?? 'Tidak Ada',
            'updated_at_iot' => optional($user->status)->updated_at_iot,
        ]);
    }
}
