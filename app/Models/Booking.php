<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'nama_mahasiswa',
        'email_mahasiswa',
        'nim_mahasiswa',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'keperluan',
        'ruangan',           // ← ini kolom string biasa
        'catatan_dosen',
        'status',
        'alasan_reject',
        'approved_at',
        'rejected_at',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'approved_at'     => 'datetime',
        'rejected_at'     => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ❌ TIDAK PERLU ini karena ruangan bukan foreign key:
    // public function ruangan() { ... }
}
