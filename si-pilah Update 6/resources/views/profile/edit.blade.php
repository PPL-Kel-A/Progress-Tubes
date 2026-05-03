<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Profil — {{ config('app.name', 'Si-Pilah') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="antialiased" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 40%, #f0f9e8 100%); min-height: 100vh;">

    {{-- ── Back Button ── --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm font-semibold text-green-700 hover:text-green-900 transition group">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    {{-- ── Hero Banner ── --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 mb-8">
        <div class="relative overflow-hidden rounded-2xl shadow-lg" style="background: linear-gradient(135deg, #0d3b0e 0%, #1b5e20 40%, #2e7d32 70%, #388e3c 100%);">
            {{-- Decorative leaf pattern --}}
            <div class="absolute inset-0 opacity-[.06]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath d='M30 2C30 2 15 15 15 30C15 42 22 50 30 58C38 50 45 42 45 30C45 15 30 2 30 2Z' fill='%23ffffff'/%3E%3C/svg%3E&quot;); background-size: 60px 60px;"></div>
            {{-- Radial glow --}}
            <div class="absolute inset-0" style="background: radial-gradient(ellipse 500px 400px at 80% 50%, rgba(76,175,80,.2) 0%, transparent 70%);"></div>

            <div class="relative px-8 py-10 flex flex-col sm:flex-row items-start sm:items-center gap-6">
                {{-- Avatar --}}
                <div class="flex-shrink-0">
                    @if (auth()->user()->profile_photo)
                        <img src="{{ Storage::url(auth()->user()->profile_photo) }}" 
                             alt="Profile Photo" 
                             class="w-20 h-20 rounded-2xl object-cover shadow-inner border-3 border-white/30">
                    @else
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-3xl font-extrabold text-green-800 shadow-inner" style="background: linear-gradient(135deg, #a5d6a7, #c8e6c9); border: 3px solid rgba(255,255,255,.3);">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-white truncate">
                        {{ auth()->user()->name }}
                    </h1>
                    <p class="text-green-200 text-sm mt-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ auth()->user()->email }}
                    </p>
                    <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold" style="background: rgba(255,255,255,.15); color: #a5d6a7; backdrop-filter: blur(8px);">
                        🌱 Eco Warrior — Mari jaga bumi bersama Si-Pilah
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Form Cards ── --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 pb-12">

        {{-- Profile Information Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-100/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="px-6 py-4 border-b border-green-50 flex items-center gap-3" style="background: linear-gradient(90deg, #f0fdf4, #ffffff);">
                <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-green-100 text-green-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </span>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Informasi Profil</h3>
                    <p class="text-xs text-gray-500">Perbarui nama dan alamat email akun Anda</p>
                </div>
            </div>
            <div class="px-6 py-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Profile Photo Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-cyan-100/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="px-6 py-4 border-b border-cyan-50 flex items-center gap-3" style="background: linear-gradient(90deg, #ecf7f8, #ffffff);">
                <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-cyan-100 text-cyan-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Foto Profil</h3>
                    <p class="text-xs text-gray-500">Unggah atau ubah foto profil akun Anda</p>
                </div>
            </div>
            <div class="px-6 py-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-photo-form')
                </div>
            </div>
        </div>

        {{-- Password Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-100/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="px-6 py-4 border-b border-emerald-50 flex items-center gap-3" style="background: linear-gradient(90deg, #ecfdf5, #ffffff);">
                <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </span>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Keamanan Akun</h3>
                    <p class="text-xs text-gray-500">Gunakan kata sandi yang kuat untuk melindungi akun Anda</p>
                </div>
            </div>
            <div class="px-6 py-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Delete Account Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-red-100/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="px-6 py-4 border-b border-red-50 flex items-center gap-3" style="background: linear-gradient(90deg, #fef2f2, #ffffff);">
                <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-red-100 text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </span>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Zona Bahaya</h3>
                    <p class="text-xs text-gray-500">Tindakan ini bersifat permanen dan tidak dapat dibatalkan</p>
                </div>
            </div>
            <div class="px-6 py-6">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>

</body>
</html>