<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'updated_at_iot',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
