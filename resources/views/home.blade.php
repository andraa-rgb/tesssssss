@extends('layouts.app')

@section('title','Jadwal Dosen Lab WICIDA')

@section('content')
<div class="mb-10 text-center">
    <h1 class="text-3xl md:text-4xl font-bold mb-2">Sistem Jadwal Dosen Lab WICIDA</h1>
    <p class="text-base-content/70">
        Lihat status real-time dan jadwal dosen, serta booking konsultasi dengan mudah.
    </p>
</div>

<div class="grid gap-6 md:grid-cols-3">
    @foreach($dosens as $dosen)
        @php
            $status = optional($dosen->status)->status ?? 'Tidak Ada';
            $color = match($status) {
                'Ada' => 'badge-success',
                'Mengajar' => 'badge-warning',
                'Konsultasi' => 'badge-info',
                default => 'badge-neutral',
            };
            $emoji = match($status) {
                'Ada' => '🟢',
                'Mengajar' => '🟡',
                'Konsultasi' => '🔵',
                default => '⚪',
            };
        @endphp
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="card-title">{{ $dosen->name }}</h2>
                    <div class="badge {{ $color }} gap-1">
                        {{ $emoji }} {{ $status }}
                    </div>
                </div>
                <p class="text-sm text-base-content/70">
                    NIP: {{ $dosen->nip ?? '-' }}
                </p>
                <p class="text-sm text-base-content/70 mb-4 capitalize">
                    Role: {{ str_replace('_',' ', $dosen->role) }}
                </p>

                <div class="flex flex-col gap-2 mt-2">
                    <a href="{{ route('dosen.show',$dosen) }}" class="btn btn-outline btn-sm">
                        Lihat Jadwal
                    </a>
                    <a href="{{ route('dosen.show',$dosen) }}#booking" class="btn btn-primary btn-sm">
                        Booking Konsultasi
                    </a>
                </div>

                <div class="mt-4">
                    <div class="text-xs text-base-content/60 mb-1">QR Code (placeholder)</div>
                    <div class="w-20 h-20 border-dashed border-2 border-base-300 rounded-lg flex items-center justify-center text-xs text-base-content/50">
                        QR Code
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
