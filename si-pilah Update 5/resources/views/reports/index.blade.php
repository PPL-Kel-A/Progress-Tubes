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

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            60% { transform: translateY(-20px); }
        }
        .float {
            animation: float 2.5s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

@include('partials.navbar', ['variant' => 'dashboard'])

<div class="w-full px-6 md:px-10 lg:px-16 py-10">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium mb-6"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 4000)"
             x-transition>
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-4 gap-6 mb-10 items-stretch">

        <div class="lg:col-span-3 bg-sipilah-green text-white rounded-2xl px-10 py-6 shadow-lg">
            <div class="max-w-3xl">
                <p class="text-green-200 text-sm mb-2">
                    Halo, {{ auth()->user()->name ?? 'User' }} 👋
                </p>

                <h1 class="text-3xl font-bold leading-tight mb-3">
                    Pantau status laporanmu di sini 📋
                </h1>

                <p class="text-green-100 text-base mb-6">
                    Setiap laporan yang kamu kirim membantu menjaga lingkungan 🌱
                </p>

                <div class="flex gap-4 flex-wrap">
                    <a href="{{ route('reports.create') }}"
                       class="bg-white text-green-700 px-6 py-3 rounded-full font-bold text-sm hover:bg-gray-100 transition">
                        + Buat Laporan
                    </a>

                    <a href="/dashboard"
                       class="border border-white px-6 py-3 rounded-full text-sm font-semibold hover:bg-white hover:text-green-700 transition">
                        Kembali Ke Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl px-6 py-6 shadow-lg border border-gray-100 flex flex-col justify-center items-center text-center">
            <div class="text-4xl mb-2">📊</div>

            <p class="text-sm text-gray-500">Total Laporan</p>

            <h2 class="text-3xl font-bold text-sipilah-green mt-1">
                {{ $reports->count() }}
            </h2>

            <p class="text-xs text-gray-400 mt-1">
                laporan telah dibuat
            </p>
        </div>

    </div>

    <div class="space-y-4">

        @forelse ($reports as $report)

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition"
                 x-data="{ expanded: false }">

                <div class="flex justify-between items-start">
                    <div class="flex-1 min-w-0">
                        <h2 class="font-bold text-gray-800">{{ $report->judul }}</h2>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $report->created_at->translatedFormat('d F Y, H:i') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3 ml-4">
                        @php
                            $colors = [
                                'Menunggu' => 'yellow',
                                'Diproses' => 'blue',
                                'Selesai' => 'green',
                                'Dibatalkan' => 'red'
                            ];
                            $c = $colors[$report->status] ?? 'gray';
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-{{ $c }}-100 text-{{ $c }}-700">
                            {{ $report->status }}
                        </span>

                        <button @click="expanded = !expanded"
                                class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-5 h-5 transition-transform"
                                 :class="{ 'rotate-180': expanded }"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div x-show="expanded"
                     x-transition
                     class="mt-4 pt-4 border-t border-gray-100"
                     style="display:none;">
                    <p class="text-sm text-gray-600">
                        {{ $report->deskripsi }}
                    </p>
                </div>

            </div>

        @empty

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-14 text-center relative overflow-hidden">
                
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-40"></div>

                <div class="relative z-10">

                    <div class="text-6xl mb-6 float">📭</div>

                    <h2 class="text-lg font-bold text-gray-700 mb-2">
                        Belum ada laporan
                    </h2>

                    <p class="text-gray-400 text-sm mb-6 max-w-sm mx-auto">
                        Kamu belum membuat laporan. Yuk mulai kontribusi untuk lingkungan 🌱
                    </p>

                    <a href="{{ route('reports.create') }}"
                       class="bg-sipilah-green text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-green-700 transition shadow-sm inline-block">
                        + Buat Laporan Pertama
                    </a>

                </div>

            </div>

        @endforelse

    </div>

</div>

@include('partials.footer')

</body>
</html>