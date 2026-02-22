<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lightElegant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Lab WICIDA') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-10 bg-gradient-to-br from-primary/10 via-secondary/10 to-accent/10">

    <div class="w-full max-w-md">
        {{-- Logo & Title --}}
        <div class="text-center mb-6 animate-fadeInUp">
            <div class="inline-flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-2xl gradient-purple-pink flex items-center justify-center text-base-100 shadow-lg">
                    <span class="text-3xl"></span>
                </div>
                <div class="flex flex-col items-start leading-tight">
                    <span class="font-bold text-xl text-base-content">Lab WICIDA</span>
                    <span class="text-xs text-base-content/60">Sistem Jadwal & Booking Dosen</span>
                </div>
            </div>
        </div>

        {{-- Login Card --}}
        <div class="glass-card rounded-3xl shadow-2xl border border-base-300/60 animate-fadeIn delay-100">
            <div class="p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-base-content">
                        Masuk ke Akun
                    </h2>
                    <span class="badge badge-primary badge-outline text-[10px] uppercase tracking-wide">
                        Secure Login
                    </span>
                </div>

                <p class="text-xs sm:text-sm text-base-content/60 mb-5">
                    Gunakan email kampus dan password yang telah diberikan administrator.
                </p>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="alert alert-success mb-4 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-xs sm:text-sm">Email</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-base-content/40">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="input input-bordered w-full pl-9 text-sm @error('email') input-error @enderror"
                                placeholder="nama@lab-wicida.ac.id"
                                required
                                autofocus
                            />
                        </div>
                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error text-xs">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-xs sm:text-sm">Password</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-base-content/40">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input
                                type="password"
                                name="password"
                                class="input input-bordered w-full pl-9 text-sm @error('password') input-error @enderror"
                                placeholder="••••••••"
                                required
                            />
                        </div>
                        @error('password')
                            <label class="label">
                                <span class="label-text-alt text-error text-xs">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Remember + Forgot password --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mt-1">
                        <label class="label cursor-pointer justify-start gap-2 px-0">
                            <input type="checkbox" name="remember" class="checkbox checkbox-xs checkbox-primary" />
                            <span class="label-text text-xs">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link link-primary text-xs">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    {{-- Login button --}}
                    <button type="submit" class="btn btn-primary w-full mt-4 gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login
                    </button>
                </form>

                {{-- Divider --}}
                <div class="divider my-5 text-xs text-base-content/60">atau</div>

                {{-- Back to home --}}
                <a href="{{ route('home') }}" class="btn btn-outline btn-sm w-full gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Kembali ke Home
                </a>

                {{-- Help text --}}
                <div class="text-center mt-5 text-[11px] sm:text-xs text-base-content/70">
                    <p>Belum punya akun? Hubungi administrator Lab WICIDA untuk registrasi.</p>
                </div>
            </div>
        </div>

        {{-- Demo credentials (opsional untuk development) --}}
        <div class="mt-4 text-[11px] sm:text-xs text-base-content/60 animate-fadeIn delay-200">
            <div class="glass-card rounded-2xl p-3 space-y-1">
                <div class="font-semibold flex items-center gap-2 mb-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                    Demo Login (development):
                </div>
                <div class="grid gap-1">
                    <div><span class="font-semibold">Admin:</span> admin@lab-wicida.ac.id / admin123</div>
                    <div><span class="font-semibold">Dosen:</span> budi@lab-wicida.ac.id / password</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
