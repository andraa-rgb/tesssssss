<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'status' => 'required|in:Ada,Mengajar,Konsultasi,Tidak Ada',
        ]);

        $status = Status::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'status' => $data['status'],
                'updated_at_iot' => now(),
            ]
        );

        return response()->json([
            'message' => 'Status berhasil diperbarui',
            'data'    => $status,
        ]);
    }
}
