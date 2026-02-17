<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = auth()->user()
            ->jadwals()
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('jam_mulai')
            ->paginate(10);

        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('jadwal.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kegiatan'    => 'required|in:Mengajar,Konsultasi,Rapat,Lainnya',
            'ruangan'     => 'nullable|string|max:100',
            'keterangan'  => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();

        Jadwal::create($data);

        return redirect()->route('jadwal.index')->with('success','Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        $this->authorizeOwner($jadwal);

        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $this->authorizeOwner($jadwal);

        $data = $request->validate([
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kegiatan'    => 'required|in:Mengajar,Konsultasi,Rapat,Lainnya',
            'ruangan'     => 'nullable|string|max:100',
            'keterangan'  => 'nullable|string',
        ]);

        $jadwal->update($data);

        return redirect()->route('jadwal.index')->with('success','Jadwal berhasil diupdate.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $this->authorizeOwner($jadwal);

        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success','Jadwal berhasil dihapus.');
    }

    protected function authorizeOwner(Jadwal $jadwal)
    {
        abort_unless($jadwal->user_id === auth()->id(), 403);
    }
}
