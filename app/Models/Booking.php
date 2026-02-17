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
        'status',
        'alasan_reject',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
