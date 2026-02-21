<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nip',
        'photo',
        'expertise',
        'bio',
        'scholar_url',
        'sinta_url',
        'website_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke jadwal dosen
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    // Relasi ke status ketersediaan real-time
    public function status()
    {
        return $this->hasOne(Status::class);
    }

    // Relasi ke booking konsultasi (booking yang ditujukan ke dosen ini)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
