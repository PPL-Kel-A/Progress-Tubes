<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    @include('partials.navbar', ['variant' => 'dashboard'])

    <div class="min-h-screen" style="background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 50%, #ecfdf5 100%);">
        <div class="container mx-auto px-4 sm:px-6 py-8 max-w-4xl">

            {{-- Page Header --}}
            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-green-700 hover:text-green-900 transition group mb-4">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke Dashboard
                </a>

                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #1b5e20, #2e7d32);">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Pengumuman</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Kabar terbaru dan informasi penting dari Si-Pilah</p>
                    </div>
                </div>
            </div>

            {{-- Announcements List --}}
            @if($announcements->count() > 0)
                <div class="space-y-4">
                    @foreach($announcements as $index => $announcement)
                    @php
                        $isNew = $announcement->created_at->diffInDays(now()) < 3;
                        $timeAgo = $announcement->created_at->diffForHumans();
                    @endphp
                    <div class="group bg-white rounded-2xl border {{ $isNew ? 'border-green-200 shadow-md' : 'border-gray-100 shadow-sm' }} overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="flex">
                            {{-- Left accent bar --}}
                            <div class="w-1.5 flex-shrink-0 {{ $isNew ? 'bg-gradient-to-b from-green-500 to-emerald-500' : 'bg-gray-200' }}"></div>

                            <div class="flex-1 px-6 py-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        {{-- Badge --}}
                                        <div class="flex items-center gap-2 mb-3">
                                            @if($isNew)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-green-100 text-green-700 uppercase tracking-wider">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                    Baru
                                                </span>
                                            @endif
                                            <span class="text-xs text-gray-400 font-medium">
                                                {{ $announcement->created_at->translatedFormat('l, d F Y') }}
                                            </span>
                                        </div>

                                        {{-- Content --}}
                                        <p class="text-gray-700 leading-relaxed text-[15px]">
                                            {{ $announcement->konten }}
                                        </p>

                                        {{-- Footer --}}
                                        <div class="flex items-center gap-4 mt-4 pt-3 border-t border-gray-50">
                                            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                {{ $timeAgo }}
                                            </div>
                                            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                Tim Si-Pilah
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Right icon --}}
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-10 h-10 rounded-xl {{ $isNew ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-400' }} flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $announcements->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm py-16 text-center">
                    <div class="w-20 h-20 mx-auto rounded-2xl bg-green-50 flex items-center justify-center mb-5">
                        <svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700 mb-1">Belum Ada Pengumuman</h3>
                    <p class="text-sm text-gray-400 max-w-sm mx-auto">Saat ini belum ada pengumuman dari tim Si-Pilah. Pengumuman baru akan muncul di sini.</p>
                </div>
            @endif

        </div>
    </div>

    @include('partials.footer')

</body>
</html>
