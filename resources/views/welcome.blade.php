<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Jadwal Dosen - Lab WICIDA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation { animation: float 3s ease-in-out infinite; }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient-shift 15s ease infinite;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Enhanced Navbar with Blur Effect -->
    <div class="navbar bg-base-100/80 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-base-300">
        <div class="max-w-7xl mx-auto w-full px-4 lg:px-8">
            <div class="flex-1">
                <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl gap-2 hover:scale-105 transition-transform">
                    <span class="text-4xl float-animation">📚</span>
                    <div class="flex flex-col items-start">
                        <span class="font-bold bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">
                            Lab WICIDA
                        </span>
                        <span class="text-[10px] text-base-content/60 font-normal">Jadwal Dosen</span>
                    </div>
                </a>
            </div>

            <div class="flex-none">
                <div class="hidden lg:flex items-center gap-2 mr-4">
                    <a href="#home" class="btn btn-ghost btn-sm hover:bg-primary/10 hover:text-primary transition-colors">Home</a>
                    <a href="#dosen" class="btn btn-ghost btn-sm hover:bg-primary/10 hover:text-primary transition-colors">Dosen</a>
                    <a href="#features" class="btn btn-ghost btn-sm hover:bg-primary/10 hover:text-primary transition-colors">Fitur</a>
                </div>

                <div class="flex items-center gap-2">
                    <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm">
                        <input type="checkbox" id="theme-toggle-checkbox" />
                        <svg class="swap-on fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>
                        <svg class="swap-off fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>
                    </label>

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm gap-2 shadow-lg hover:shadow-xl transition-shadow">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="hidden sm:inline">Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Login
                        </a>
                    @endauth

                    <!-- Mobile Menu -->
                    <div class="dropdown dropdown-end lg:hidden">
                        <label tabindex="0" class="btn btn-ghost btn-circle btn-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </label>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow-xl bg-base-100 rounded-box w-52 mt-2 border border-base-300">
                            <li><a href="#home" class="gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>Home</a></li>
                            <li><a href="#dosen" class="gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>Dosen</a></li>
                            <li><a href="#features" class="gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>Fitur</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section with Gradient Animation -->
    <section id="home" class="relative min-h-[92vh] overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-secondary/20 to-accent/20 gradient-animate"></div>
        
        <!-- Decorative Elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-secondary/10 rounded-full blur-3xl"></div>
        
        <div class="relative hero-content text-center max-w-5xl mx-auto px-4 py-20">
            <div>
                <!-- Floating Icon -->
                <div class="mb-8">
                    <div class="inline-block p-8 bg-gradient-to-br from-primary/20 to-secondary/20 rounded-3xl shadow-2xl float-animation backdrop-blur-sm">
                        <span class="text-9xl">📚</span>
                    </div>
                </div>
                
                <!-- Main Title with Gradient -->
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                    <span class="block text-base-content">Sistem Jadwal Dosen</span>
                    <span class="block mt-3 bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent animate-pulse">
                        Lab WICIDA
                    </span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-lg sm:text-xl lg:text-2xl mb-10 text-base-content/80 max-w-3xl mx-auto leading-relaxed">
                    Transparansi jadwal <span class="font-semibold text-primary">real-time</span> dan booking konsultasi yang <span class="font-semibold text-secondary">mudah</span> untuk mahasiswa dan dosen.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-4 justify-center mb-12">
                    <a href="#dosen" class="btn btn-primary btn-lg gap-3 shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Lihat Jadwal Dosen
                    </a>
                    <a href="#features" class="btn btn-outline btn-lg gap-3 hover:scale-105 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Pelajari Fitur
                    </a>
                </div>

                <!-- Enhanced Stats with Glass Effect -->
                <div class="stats stats-vertical sm:stats-horizontal shadow-2xl glass-effect border border-base-300">
                    <div class="stat hover:bg-primary/5 transition-colors">
                        <div class="stat-figure text-primary">
                            <div class="avatar placeholder">
                                <div class="bg-primary/20 text-primary rounded-full w-16">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="stat-title font-semibold">Dosen Aktif</div>
                        <div class="stat-value text-primary text-4xl">{{ \App\Models\User::whereIn('role',['kepala_lab','staf'])->count() }}</div>
                        <div class="stat-desc font-medium">Lab WICIDA</div>
                    </div>
                    
                    <div class="stat hover:bg-secondary/5 transition-colors">
                        <div class="stat-figure text-secondary">
                            <div class="avatar placeholder">
                                <div class="bg-secondary/20 text-secondary rounded-full w-16">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="stat-title font-semibold">Jadwal Tersedia</div>
                        <div class="stat-value text-secondary text-4xl">{{ \App\Models\Jadwal::count() }}</div>
                        <div class="stat-desc font-medium">Senin - Jumat</div>
                    </div>
                    
                    <div class="stat hover:bg-accent/5 transition-colors">
                        <div class="stat-figure text-accent">
                            <div class="avatar placeholder">
                                <div class="bg-accent/20 text-accent rounded-full w-16">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="stat-title font-semibold">Booking Aktif</div>
                        <div class="stat-value text-accent text-4xl">{{ \App\Models\Booking::whereIn('status',['pending','approved'])->count() }}</div>
                        <div class="stat-desc font-medium">Konsultasi Terjadwal</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#dosen" class="flex flex-col items-center text-base-content/60 hover:text-primary transition-colors">
                <span class="text-sm mb-2">Scroll untuk lanjut</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </a>
        </div>
    </section>

    <!-- Dosen Section with Modern Cards -->
    <section id="dosen" class="py-20 bg-base-100">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="badge badge-primary badge-lg mb-4 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Jadwal Dosen
                </div>
                <h2 class="text-4xl sm:text-5xl font-black mb-4 bg-gradient-to-r from-base-content to-base-content/70 bg-clip-text">
                    Dosen Lab WICIDA
                </h2>
                <p class="text-xl text-base-content/70 max-w-2xl mx-auto">
                    Lihat status <span class="text-success font-semibold">real-time</span> dan jadwal lengkap dosen kami
                </p>
            </div>

            <!-- Dosen Cards Grid -->
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($dosens as $index => $dosen)
                    @php
                        $status = optional($dosen->status)->status ?? 'Tidak Ada';
                        $colorMap = [
                            'Ada' => ['badge' => 'badge-success', 'emoji' => '🟢', 'bg' => 'from-success/20 via-success/10 to-transparent', 'ring' => 'ring-success/30'],
                            'Mengajar' => ['badge' => 'badge-warning', 'emoji' => '🟡', 'bg' => 'from-warning/20 via-warning/10 to-transparent', 'ring' => 'ring-warning/30'],
                            'Konsultasi' => ['badge' => 'badge-info', 'emoji' => '🔵', 'bg' => 'from-info/20 via-info/10 to-transparent', 'ring' => 'ring-info/30'],
                            'Tidak Ada' => ['badge' => 'badge-neutral', 'emoji' => '⚪', 'bg' => 'from-neutral/20 via-neutral/10 to-transparent', 'ring' => 'ring-neutral/30'],
                        ];
                        $style = $colorMap[$status];
                    @endphp
                    
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-base-300 group"
                         data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        
                        <!-- Card Top Gradient Bar -->
                        <div class="h-2 bg-gradient-to-r {{ $style['bg'] }} rounded-t-2xl"></div>
                        
                        <div class="card-body p-6">
                            <!-- Avatar & Name -->
                            <div class="flex items-start gap-4 mb-6">
                                <div class="avatar placeholder">
                                    <div class="bg-gradient-to-br from-primary to-secondary text-white rounded-full w-20 h-20 ring-4 {{ $style['ring'] }} group-hover:ring-8 transition-all duration-300">
                                        <span class="text-3xl font-bold">{{ substr($dosen->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="card-title text-xl mb-1 truncate">{{ $dosen->name }}</h3>
                                    <p class="text-sm text-base-content/60 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                        {{ $dosen->nip ?? 'N/A' }}
                                    </p>
                                    <div class="badge badge-outline badge-sm capitalize mt-2">
                                        {{ str_replace('_', ' ', $dosen->role) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Status Badge with Pulse Animation -->
                            <div class="flex items-center justify-between mb-6 p-4 bg-base-200 rounded-xl">
                                <span class="text-sm font-semibold text-base-content/70 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Status Real-Time
                                </span>
                                <div class="relative">
                                    <div class="badge {{ $style['badge'] }} badge-lg gap-2 shadow-lg">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background-color: currentColor;"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2" style="background-color: currentColor;"></span>
                                        </span>
                                        {{ $status }}
                                    </div>
                                </div>
                            </div>

                            <!-- Mini Stats Grid -->
                            <div class="grid grid-cols-2 gap-3 mb-6">
                                <div class="stat bg-primary/5 rounded-xl p-3 hover:bg-primary/10 transition-colors">
                                    <div class="stat-title text-xs text-primary font-semibold">Jadwal</div>
                                    <div class="stat-value text-2xl text-primary">{{ $dosen->jadwals->count() }}</div>
                                </div>
                                <div class="stat bg-secondary/5 rounded-xl p-3 hover:bg-secondary/10 transition-colors">
                                    <div class="stat-title text-xs text-secondary font-semibold">Booking</div>
                                    <div class="stat-value text-2xl text-secondary">{{ $dosen->bookings()->where('status','pending')->count() }}</div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('dosen.show', $dosen) }}" 
                                   class="btn btn-primary btn-block gap-2 shadow-md hover:shadow-xl transition-all group-hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Lihat Jadwal Lengkap
                                </a>
                                <a href="{{ route('dosen.show', $dosen) }}#booking" 
                                   class="btn btn-outline btn-block gap-2 hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Booking Konsultasi
                                </a>
                            </div>

                            <!-- QR Code Section -->
                            <div class="divider text-xs font-semibold">Quick Access</div>
                            <div class="flex justify-center">
                                <div class="relative group/qr">
                                    <div class="w-28 h-28 border-2 border-dashed border-base-300 rounded-xl flex items-center justify-center hover:border-primary hover:bg-primary/5 transition-all cursor-pointer">
                                        <div class="text-center">
                                            <div class="text-3xl mb-1">📱</div>
                                            <div class="text-xs text-base-content/60 font-medium">Scan QR</div>
                                        </div>
                                    </div>
                                    <div class="absolute -top-2 -right-2 badge badge-sm badge-primary shadow-lg opacity-0 group-hover/qr:opacity-100 transition-opacity">
                                        Soon
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($dosens->isEmpty())
                <div class="text-center py-20">
                    <div class="text-8xl mb-6 opacity-50">😔</div>
                    <h3 class="text-2xl font-bold mb-2">Belum Ada Data Dosen</h3>
                    <p class="text-lg text-base-content/70">Silakan hubungi administrator untuk informasi lebih lanjut.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gradient-to-b from-base-100 to-base-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="badge badge-secondary badge-lg mb-4 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Fitur Unggulan
                </div>
                <h2 class="text-4xl sm:text-5xl font-black mb-4">Kenapa Memilih Sistem Kami?</h2>
                <p class="text-xl text-base-content/70 max-w-2xl mx-auto">
                    Sistem yang dirancang untuk memudahkan komunikasi dan koordinasi
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $features = [
                        ['icon' => '🕐', 'title' => 'Status Real-Time', 'desc' => 'Pantau ketersediaan dosen secara real-time dengan update otomatis dari perangkat IoT atau manual.', 'color' => 'primary'],
                        ['icon' => '📅', 'title' => 'Jadwal Lengkap', 'desc' => 'Lihat jadwal mingguan dosen (Senin-Jumat) dengan detail kegiatan, ruangan, dan keterangan.', 'color' => 'secondary'],
                        ['icon' => '📝', 'title' => 'Booking Mudah', 'desc' => 'Submit booking konsultasi dengan form sederhana. Dosen dapat approve/reject langsung.', 'color' => 'accent'],
                        ['icon' => '📱', 'title' => 'Responsive', 'desc' => 'Akses dari smartphone, tablet, atau desktop dengan tampilan optimal di semua perangkat.', 'color' => 'success'],
                        ['icon' => '🔔', 'title' => 'Notifikasi', 'desc' => 'Terima notifikasi saat booking disetujui/ditolak (fitur akan datang dengan email notification).', 'color' => 'warning'],
                        ['icon' => '🔐', 'title' => 'Secure', 'desc' => 'Data mahasiswa dan dosen terlindungi dengan enkripsi dan autentikasi yang aman.', 'color' => 'info'],
                    ];
                @endphp

                @foreach($features as $index => $feature)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border border-base-300 hover:border-{{ $feature['color'] }} group"
                         data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="card-body">
                            <div class="w-16 h-16 bg-{{ $feature['color'] }}/10 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                                <span class="text-5xl">{{ $feature['icon'] }}</span>
                            </div>
                            <h3 class="card-title text-xl mb-2">{{ $feature['title'] }}</h3>
                            <p class="text-base-content/70 leading-relaxed">{{ $feature['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-primary via-secondary to-accent gradient-animate relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative max-w-4xl mx-auto px-4 text-center text-white" data-aos="zoom-in">
            <h2 class="text-4xl sm:text-5xl font-black mb-6">Siap Booking Konsultasi?</h2>
            <p class="text-xl sm:text-2xl mb-10 opacity-90 max-w-2xl mx-auto">
                Pilih dosen, lihat jadwal, dan booking konsultasi dengan mudah!
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="#dosen" class="btn btn-lg bg-white text-primary hover:bg-base-100 border-0 gap-3 shadow-2xl hover:scale-110 transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Lihat Jadwal Sekarang
                </a>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-lg btn-outline text-white border-white hover:bg-white hover:text-primary gap-3 hover:scale-110 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login Dosen
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer footer-center p-10 bg-base-200 text-base-content border-t border-base-300">
        <div>
            <div class="text-5xl mb-4 float-animation">📚</div>
            <p class="font-bold text-xl">Lab WICIDA - Sistem Jadwal Dosen</p>
            <p class="text-base-content/70">Transparansi & Efisiensi dalam Penjadwalan</p>
        </div>
        <div>
            <div class="grid grid-flow-col gap-6">
                <a href="#" class="link link-hover hover:text-primary transition-colors">Tentang</a>
                <a href="#" class="link link-hover hover:text-primary transition-colors">Kontak</a>
                <a href="#" class="link link-hover hover:text-primary transition-colors">FAQ</a>
                <a href="#" class="link link-hover hover:text-primary transition-colors">Privacy</a>
            </div>
        </div>
        <div>
            <p class="text-sm">© {{ date('Y') }} Lab WICIDA. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <button id="scrollToTop" class="btn btn-circle btn-primary fixed bottom-8 right-8 shadow-2xl hidden z-50 hover:scale-125 transition-transform">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        // Scroll to top
        const scrollBtn = document.getElementById('scrollToTop');
        window.addEventListener('scroll', () => {
            scrollBtn.classList.toggle('hidden', window.scrollY < 400);
        });
        scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        // Theme toggle
        const toggle = document.getElementById('theme-toggle-checkbox');
        const html = document.documentElement;
        const saved = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', saved);
        toggle.checked = saved === 'dark';
        
        toggle.addEventListener('change', () => {
            const theme = toggle.checked ? 'dark' : 'light';
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        });
    </script>
</body>
</html>
