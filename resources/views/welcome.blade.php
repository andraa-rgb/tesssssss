<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Jadwal Dosen - Lab WICIDA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200">

{{-- NAVBAR SIMPLE --}}
<div class="navbar bg-base-100 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto w-full px-4">
        <div class="flex-1">
            <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl gap-2">
                <span class="text-3xl">📚</span>
                <span class="font-bold">Lab WICIDA</span>
            </a>
        </div>
        <div class="flex-none gap-2">
            <a href="#dosen" class="btn btn-ghost btn-sm">Dosen</a>
            <a href="#features" class="btn btn-ghost btn-sm">Fitur</a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Login Dosen</a>
            @endauth
        </div>
    </div>
</div>

{{-- HERO --}}
<section id="home" class="min-h-[80vh] flex items-center justify-center bg-gradient-to-br from-primary/20 via-secondary/20 to-accent/20">
    <div class="max-w-4xl mx-auto text-center px-4">
        <div class="mb-6">
            <div class="inline-block p-6 bg-base-100/80 rounded-3xl shadow-xl">
                <span class="text-7xl">📅</span>
            </div>
        </div>
        <h1 class="text-4xl md:text-6xl font-black mb-4">
            Sistem Jadwal Dosen
            <span class="block text-primary">Lab WICIDA</span>
        </h1>
        <p class="text-lg md:text-xl text-base-content/80 mb-8">
            Transparansi jadwal dan booking konsultasi dosen secara real-time.
        </p>
        <div class="flex flex-wrap justify-center gap-4 mb-10">
            <a href="#dosen" class="btn btn-primary btn-lg gap-2">
                Lihat Jadwal Dosen
            </a>
            <a href="#features" class="btn btn-outline btn-lg">
                Lihat Fitur
            </a>
        </div>

        <div class="stats stats-vertical md:stats-horizontal bg-base-100 shadow-xl">
            <div class="stat">
                <div class="stat-title">Dosen Aktif</div>
                <div class="stat-value text-primary">{{ \App\Models\User::whereIn('role',['kepala_lab','staf'])->count() }}</div>
            </div>
            <div class="stat">
                <div class="stat-title">Jadwal Tersedia</div>
                <div class="stat-value text-secondary">{{ \App\Models\Jadwal::count() }}</div>
            </div>
            <div class="stat">
                <div class="stat-title">Booking Aktif</div>
                <div class="stat-value text-accent">{{ \App\Models\Booking::whereIn('status',['pending','approved'])->count() }}</div>
            </div>
        </div>
    </div>
</section>

{{-- Dosen list singkat --}}
<section id="dosen" class="py-16 bg-base-100">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-6 text-center">Dosen Lab WICIDA</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($dosens as $dosen)
                <div class="card bg-base-100 shadow-md border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-12">
                                    <span class="text-xl">{{ substr($dosen->name,0,1) }}</span>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-semibold">{{ $dosen->name }}</h3>
                                <p class="text-xs text-base-content/60">{{ $dosen->nip ?? 'NIP belum diisi' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('dosen.show',$dosen) }}" class="btn btn-primary btn-sm btn-block">
                            Lihat Detail & Jadwal
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @if($dosens->isEmpty())
            <p class="text-center text-base-content/70 mt-6">Belum ada data dosen.</p>
        @endif
    </div>
</section>

{{-- Fitur --}}
<section id="features" class="py-16 bg-base-200">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-6 text-center">Fitur Utama</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title">Status Real-time</h3>
                    <p>Pantau ketersediaan dosen secara langsung.</p>
                </div>
            </div>
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title">Jadwal Terstruktur</h3>
                    <p>Jadwal per hari, per jam, dan per kegiatan.</p>
                </div>
            </div>
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title">Booking Konsultasi</h3>
                    <p>Mahasiswa dapat mengajukan konsultasi online.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer footer-center p-6 bg-base-100 text-base-content border-t border-base-300">
    <div>
        <p>© {{ date('Y') }} Lab WICIDA. Sistem Jadwal Dosen.</p>
    </div>
</footer>

<script>
    const html = document.documentElement;
    html.setAttribute('data-theme', localStorage.getItem('theme') || 'light');
</script>

</body>
</html>
