<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-primary/20 via-secondary/20 to-accent/20">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="inline-block p-4 bg-primary/20 rounded-full mb-4">
                    <span class="text-6xl">📚</span>
                </div>
                <h1 class="text-3xl font-bold mb-2">Lab WICIDA</h1>
                <p class="text-base-content/70">Sistem Jadwal Dosen</p>
            </div>

            <!-- Login Card -->
            <div class="card bg-base-100 shadow-2xl">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-4">Login</h2>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Email</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   class="input input-bordered @error('email') input-error @enderror" 
                                   placeholder="nama@lab-wicida.ac.id"
                                   required 
                                   autofocus />
                            @error('email')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-control mt-4">
                            <label class="label">
                                <span class="label-text font-semibold">Password</span>
                            </label>
                            <input type="password" 
                                   name="password" 
                                   class="input input-bordered @error('password') input-error @enderror" 
                                   placeholder="••••••••"
                                   required />
                            @error('password')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-control mt-4">
                            <label class="label cursor-pointer justify-start gap-3">
                                <input type="checkbox" name="remember" class="checkbox checkbox-primary" />
                                <span class="label-text">Remember me</span>
                            </label>
                        </div>

                        <!-- Forgot Password Link -->
                        @if (Route::has('password.request'))
                            <div class="text-right mt-2">
                                <a href="{{ route('password.request') }}" class="link link-primary text-sm">
                                    Lupa password?
                                </a>
                            </div>
                        @endif

                        <!-- Login Button -->
                        <button type="submit" class="btn btn-primary w-full mt-6 gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Login
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="divider my-6">atau</div>

                    <!-- Back to Home -->
                    <a href="{{ route('home') }}" class="btn btn-outline w-full gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kembali ke Home
                    </a>

                    <!-- Help Text -->
                    <div class="text-center mt-6 text-sm text-base-content/70">
                        <p>Belum punya akun?</p>
                        <p class="mt-1">Hubungi administrator untuk registrasi.</p>
                    </div>
                </div>
            </div>

            <!-- Demo Credentials -->
            <div class="card bg-base-200 shadow mt-6">
                <div class="card-body p-4">
                    <div class="text-xs text-base-content/70">
                        <div class="font-semibold mb-2">🔐 Demo Login:</div>
                        <div class="grid gap-1">
                            <div><strong>Admin:</strong> admin@lab-wicida.ac.id / admin123</div>
                            <div><strong>Dosen:</strong> budi@lab-wicida.ac.id / password</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Toggle (Floating) -->
    <button id="theme-toggle" class="btn btn-circle btn-ghost fixed bottom-4 right-4 shadow-lg">
        🌗
    </button>
</body>
</html>
