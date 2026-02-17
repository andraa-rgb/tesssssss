<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'user_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'kegiatan',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
