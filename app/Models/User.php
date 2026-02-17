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
        'nip',
        'photo',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function status()
    {
        return $this->hasOne(Status::class);
    }

    public function bookings()
    {
        // booking yang ditujukan ke dosen ini
        return $this->hasMany(Booking::class);
    }
}
