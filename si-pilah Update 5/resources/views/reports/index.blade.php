<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Laporan - Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    @include('partials.navbar', ['variant' => 'dashboard'])

    <div class="container mx-auto px-6 py-10 max-w-4xl">

        {{-- Flash --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium mb-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">📋 Riwayat Laporan Saya</h1>
                <p class="text-sm text-gray-400 mt-1">Pantau semua laporan yang telah kamu buat</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('reports.create') }}" class="bg-sipilah-green text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-green-700 transition shadow-sm">
                    + Buat Laporan Baru
                </a>
                <a href="/dashboard" class="bg-gray-100 text-gray-600 px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-200 transition">
                    ← Dashboard
                </a>
            </div>
        </div>

        {{-- Reports List --}}
        <div class="space-y-4">
            @forelse ($reports as $report)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition" x-data="{ expanded: false }">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <h2 class="font-bold text-gray-800">{{ $report->judul }}</h2>
                            <p class="text-xs text-gray-400 mt-1">{{ $report->created_at->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0 ml-4">
                            @php
                                $colors = ['Menunggu' => 'yellow', 'Diproses' => 'blue', 'Selesai' => 'green', 'Dibatalkan' => 'red'];
                                $c = $colors[$report->status] ?? 'gray';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-{{ $c }}-100 text-{{ $c }}-700">{{ $report->status }}</span>
                            <button @click="expanded = !expanded" class="text-gray-400 hover:text-gray-600 transition">
                                <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </div>
                    </div>
                    <div x-show="expanded" x-transition class="mt-4 pt-4 border-t border-gray-100" style="display:none;">
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $report->deskripsi }}</p>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="text-5xl mb-4">📭</div>
                    <h2 class="text-lg font-bold text-gray-700 mb-2">Belum ada laporan</h2>
                    <p class="text-gray-400 text-sm mb-6 max-w-sm mx-auto">Kamu belum membuat laporan. Yuk mulai kontribusi untuk lingkungan! 🌱</p>
                    <a href="{{ route('reports.create') }}" class="bg-sipilah-green text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-green-700 transition shadow-sm inline-block">
                        + Buat Laporan Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    @include('partials.footer')

</body>
</html>