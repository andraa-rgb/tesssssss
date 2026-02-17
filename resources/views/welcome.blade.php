<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ config('app.name', 'Laravel') }} - Modern Web App</title>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar bg-base-100 shadow-lg sticky top-0 z-50">
        <div class="navbar-start">
            <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <a class="btn btn-ghost normal-case text-xl">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent font-bold">
                    YourApp
                </span>
            </a>
        </div>
        
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="#home" class="hover:text-primary">Home</a></li>
                <li><a href="#features" class="hover:text-primary">Features</a></li>
                <li><a href="#pricing" class="hover:text-primary">Pricing</a></li>
                <li><a href="#contact" class="hover:text-primary">Contact</a></li>
            </ul>
        </div>
        
        <div class="navbar-end gap-2">
            <button id="theme-toggle" class="btn btn-ghost btn-circle">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
            <a href="/login" class="btn btn-ghost">Login</a>
            <a href="/register" class="btn btn-primary">Get Started</a>
        </div>
    </div>

    <!-- Hero Section -->
    <div id="home" class="hero min-h-screen bg-gradient-to-br from-primary/10 via-secondary/10 to-accent/10">
        <div class="hero-content text-center">
            <div class="max-w-3xl">
                <div class="mb-8 animate-bounce">
                    <div class="inline-block p-4 bg-primary/20 rounded-full">
                        <svg class="w-20 h-20 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                
                <h1 class="text-6xl font-bold mb-6">
                    Build Amazing Apps with 
                    <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                        Laravel & DaisyUI
                    </span>
                </h1>
                
                <p class="text-xl mb-8 text-base-content/70">
                    Modern, fast, and beautiful web applications powered by Laravel, Tailwind CSS, and DaisyUI components. 
                    Start building your dream project today!
                </p>
                
                <div class="flex gap-4 justify-center flex-wrap">
                    <button class="btn btn-primary btn-lg gap-2" onclick="demo_modal.showModal()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Watch Demo
                    </button>
                    <a href="#features" class="btn btn-outline btn-lg">
                        Explore Features
                    </a>
                </div>

                <!-- Stats -->
                <div class="stats shadow-xl mt-12 bg-base-100">
                    <div class="stat">
                        <div class="stat-figure text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="stat-title">Downloads</div>
                        <div class="stat-value text-primary">31K</div>
                        <div class="stat-desc">Jan 1st - Feb 1st</div>
                    </div>
                    
                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="stat-title">Users</div>
                        <div class="stat-value text-secondary">4,200</div>
                        <div class="stat-desc">↗︎ 400 (22%)</div>
                    </div>
                    
                    <div class="stat">
                        <div class="stat-figure text-accent">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div class="stat-title">Rating</div>
                        <div class="stat-value text-accent">4.9</div>
                        <div class="stat-desc">from 2,300 reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-20 bg-base-200">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-4">Powerful Features</h2>
                <p class="text-xl text-base-content/70">Everything you need to build modern web applications</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="card-body">
                        <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="card-title">Lightning Fast</h3>
                        <p>Built with Vite for instant hot module replacement and optimized production builds.</p>
                        <div class="card-actions justify-end mt-4">
                            <button class="btn btn-ghost btn-sm">Learn More →</button>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="card-body">
                        <div class="w-16 h-16 bg-secondary/10 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                        </div>
                        <h3 class="card-title">Beautiful UI</h3>
                        <p>Pre-built DaisyUI components that look amazing out of the box. No design skills needed.</p>
                        <div class="card-actions justify-end mt-4">
                            <button class="btn btn-ghost btn-sm">Learn More →</button>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="card-body">
                        <div class="w-16 h-16 bg-accent/10 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="card-title">Secure by Default</h3>
                        <p>Laravel's built-in security features protect your application from common vulnerabilities.</p>
                        <div class="card-actions justify-end mt-4">
                            <button class="btn btn-ghost btn-sm">Learn More →</button>
                        </div>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="card-body">
                        <div class="w-16 h-16 bg-success/10 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                            </svg>
                        </div>
                        <h3 class="card-title">Responsive Design</h3>
                        <p>Mobile-first approach ensures your app looks perfect on all devices and screen sizes.</p>
                        <div class="card-actions justify-end mt-4">
                            <button class="btn btn-ghost btn-sm">Learn More →</button>
                        </div>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="card-body">
                        <div class="w-16 h-16 bg-warning/10 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <h3 class="card-title">Developer Friendly</h3>
                        <p>Clean code, great documentation, and active community support for smooth development.</p>
                        <div class="card-actions justify-end mt-4">
                            <button class="btn btn-ghost btn-sm">Learn More →</button>
                        </div>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="card-body">
                        <div class="w-16 h-16 bg-info/10 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                        </div>
                        <h3 class="card-title">Easy Deployment</h3>
                        <p>Deploy to Vercel, Netlify, or any platform with just a few clicks. CI/CD ready.</p>
                        <div class="card-actions justify-end mt-4">
                            <button class="btn btn-ghost btn-sm">Learn More →</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <div id="pricing" class="py-20 bg-base-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-4">Simple Pricing</h2>
                <p class="text-xl text-base-content/70">Choose the plan that's right for you</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Free Plan -->
                <div class="card bg-base-100 shadow-xl border-2 border-base-300">
                    <div class="card-body">
                        <h3 class="card-title text-2xl">Starter</h3>
                        <div class="py-4">
                            <span class="text-5xl font-bold">$0</span>
                            <span class="text-base-content/70">/month</span>
                        </div>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                5 Projects
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Basic Support
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                1GB Storage
                            </li>
                        </ul>
                        <button class="btn btn-outline w-full">Get Started</button>
                    </div>
                </div>

                <!-- Pro Plan -->
                <div class="card bg-primary text-primary-content shadow-2xl border-4 border-primary relative transform scale-105">
                    <div class="badge badge-secondary absolute top-4 right-4">Popular</div>
                    <div class="card-body">
                        <h3 class="card-title text-2xl">Professional</h3>
                        <div class="py-4">
                            <span class="text-5xl font-bold">$29</span>
                            <span class="opacity-70">/month</span>
                        </div>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Unlimited Projects
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Priority Support
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                50GB Storage
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Advanced Analytics
                            </li>
                        </ul>
                        <button class="btn btn-secondary w-full">Get Started</button>
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="card bg-base-100 shadow-xl border-2 border-base-300">
                    <div class="card-body">
                        <h3 class="card-title text-2xl">Enterprise</h3>
                        <div class="py-4">
                            <span class="text-5xl font-bold">$99</span>
                            <span class="text-base-content/70">/month</span>
                        </div>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Everything in Pro
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                24/7 Phone Support
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Unlimited Storage
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Custom Integrations
                            </li>
                        </ul>
                        <button class="btn btn-outline w-full">Contact Sales</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="py-20 bg-base-200">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-5xl font-bold mb-4">Get in Touch</h2>
                    <p class="text-xl text-base-content/70">Have questions? We'd love to hear from you.</p>
                </div>

                <div class="card bg-base-100 shadow-2xl">
                    <div class="card-body p-8">
                        <form class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold">Full Name</span>
                                    </label>
                                    <input type="text" placeholder="John Doe" class="input input-bordered" required />
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold">Email</span>
                                    </label>
                                    <input type="email" placeholder="john@example.com" class="input input-bordered" required />
                                </div>
                            </div>
                            
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Subject</span>
                                </label>
                                <input type="text" placeholder="What's this about?" class="input input-bordered" required />
                            </div>
                            
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Message</span>
                                </label>
                                <textarea class="textarea textarea-bordered h-32" placeholder="Tell us more..." required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-full btn-lg">
                                Send Message
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer p-10 bg-base-300 text-base-content">
        <div>
            <span class="footer-title">Services</span>
            <a class="link link-hover">Branding</a>
            <a class="link link-hover">Design</a>
            <a class="link link-hover">Marketing</a>
            <a class="link link-hover">Advertisement</a>
        </div>
        <div>
            <span class="footer-title">Company</span>
            <a class="link link-hover">About us</a>
            <a class="link link-hover">Contact</a>
            <a class="link link-hover">Jobs</a>
            <a class="link link-hover">Press kit</a>
        </div>
        <div>
            <span class="footer-title">Legal</span>
            <a class="link link-hover">Terms of use</a>
            <a class="link link-hover">Privacy policy</a>
            <a class="link link-hover">Cookie policy</a>
        </div>
        <div>
            <span class="footer-title">Newsletter</span>
            <div class="form-control w-80">
                <label class="label">
                    <span class="label-text">Enter your email address</span>
                </label>
                <div class="relative">
                    <input type="text" placeholder="username@site.com" class="input input-bordered w-full pr-16" />
                    <button class="btn btn-primary absolute top-0 right-0 rounded-l-none">Subscribe</button>
                </div>
            </div>
        </div>
    </footer>
    
    <footer class="footer footer-center p-4 bg-base-300 text-base-content">
        <div>
            <p>Copyright © 2026 - All right reserved by YourApp Ltd</p>
        </div>
    </footer>

    <!-- Demo Modal -->
    <dialog id="demo_modal" class="modal">
        <div class="modal-box max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-2xl mb-4">🎥 Product Demo</h3>
            <div class="aspect-video bg-base-300 rounded-lg flex items-center justify-center mb-4">
                <div class="text-center">
                    <svg class="w-20 h-20 mx-auto text-primary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-base-content/70">Demo video will be here</p>
                </div>
            </div>
            <p class="text-base-content/70">
                Watch this quick demo to see how our platform can help you build amazing applications faster than ever before.
            </p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>
</body>
</html>
