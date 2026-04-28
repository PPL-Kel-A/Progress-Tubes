<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    @include('partials.navbar', ['variant' => 'dashboard'])

    <div class="container mx-auto px-6 py-10">
        
        <div class="bg-sipilah-green rounded-2xl p-8 text-white mb-10 shadow-lg relative overflow-hidden">
            <div class="relative z-10 w-full md:w-2/3">
                <p class="text-green-200 text-lg font-semibold mb-1 tracking-wide">
                    Halo, {{ Auth::user()->name }}! 👋
                </p>
                <h1 class="text-3xl md:text-4xl font-bold mb-2 leading-tight">
                    Terima kasih sudah menjaga bumi hari ini! 🌍
                </h1>
                <p class="text-green-100 mb-6">Setiap kilogram sampah yang Anda pilah membantu menciptakan energi bersih untuk kota kita.</p>
                
                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('waste.select') }}"
                       class="bg-white text-sipilah-green font-bold px-6 py-3 rounded-full shadow hover:bg-gray-100 transition">
                        + Setor Sampah Baru
                    </a>

                    <a href="{{ route('reports.index') }}" 
                       class="border border-white text-white font-bold px-6 py-3 rounded-full hover:bg-white/10 active:scale-95 transition">
                        Lihat Laporan Saya
                    </a>
                </div>
            </div>
        </div>

        <h2 class="text-xl font-bold text-gray-700 mb-6">Pencapaian Anda</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition">
                <div class="bg-yellow-100 p-4 rounded-full text-yellow-600 text-2xl">🎁</div>
                <div>
                    <p class="text-sm text-gray-500 font-semibold">Poin Tersedia</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($data['poin_reward']) }} <span class="text-sm font-normal">Pts</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition">
                <div class="bg-green-100 p-4 rounded-full text-green-600 text-2xl">♻️</div>
                <div>
                    <p class="text-sm text-gray-500 font-semibold">Total Sampah Disetor</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($data['total_sampah'], 1) }} <span class="text-sm font-normal">Kg</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition">
                <div class="bg-blue-100 p-4 rounded-full text-blue-600 text-2xl">⚡</div>
                <div>
                    <p class="text-sm text-gray-500 font-semibold">Kontribusi Energi Surya</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($data['energi_surya_kwh'], 1) }} <span class="text-sm font-normal">kWh</span></p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-700">Riwayat Setoran Terakhir</h2>
            <a href="{{ route('waste.select') }}" class="text-sm font-semibold text-sipilah-green hover:underline">+ Setor Baru</a>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-10">
            @if($riwayatSampah->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                            <tr>
                                <th class="px-5 py-3 text-left">Tipe</th>
                                <th class="px-5 py-3 text-left">Kategori</th>
                                <th class="px-5 py-3 text-left">Berat</th>
                                <th class="px-5 py-3 text-left">Hasil (L)</th>
                                <th class="px-5 py-3 text-left">TPS</th>
                                <th class="px-5 py-3 text-left">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($riwayatSampah as $waste)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-5 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $waste->type === 'organic' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($waste->type) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-700">{{ $waste->category }}</td>
                                <td class="px-5 py-3 font-semibold text-gray-800">{{ number_format($waste->weight, 2) }} Kg</td>
                                <td class="px-5 py-3 text-gray-600">{{ number_format($waste->result, 2) }}</td>
                                <td class="px-5 py-3 text-gray-500 text-xs max-w-[150px] truncate" title="{{ $waste->tps }}">{{ $waste->tps }}</td>
                                <td class="px-5 py-3 text-gray-400 text-xs">{{ $waste->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 text-center">
                    <div class="text-4xl mb-3">🗑️</div>
                    <p class="text-gray-400 font-medium text-sm">Belum ada setoran sampah. <a href="{{ route('waste.select') }}" class="text-sipilah-green font-bold hover:underline">Mulai setor →</a></p>
                </div>
            @endif
        </div>

        {{-- ── Jadwal Penjemputan ── --}}
        <h2 class="text-xl font-bold text-gray-700 mb-6">Jadwal Penjemputan Mendatang</h2>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-10">
            @if($jadwalMendatang->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gradient-to-r from-green-50 to-emerald-50 text-gray-500 text-xs uppercase">
                            <tr>
                                <th class="px-5 py-3 text-left">Waktu Penjemputan</th>
                                <th class="px-5 py-3 text-left">Kategori Sampah</th>
                                <th class="px-5 py-3 text-left">Petugas</th>
                                <th class="px-5 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($jadwalMendatang as $jadwal)
                            @php
                                $waktu = \Carbon\Carbon::parse($jadwal->waktu_jemput);
                                $isToday = $waktu->isToday();
                                $isTomorrow = $waktu->isTomorrow();
                            @endphp
                            <tr class="hover:bg-green-50/30 transition {{ $isToday ? 'bg-green-50/50' : '' }}">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-xl flex flex-col items-center justify-center text-center {{ $isToday ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600' }}">
                                            <span class="text-xs font-bold leading-none">{{ $waktu->translatedFormat('d') }}</span>
                                            <span class="text-[10px] uppercase leading-none mt-0.5">{{ $waktu->translatedFormat('M') }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $waktu->translatedFormat('l, d F Y') }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">🕐 {{ $waktu->format('H:i') }} WIB</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                        ♻️ {{ $jadwal->kategori }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">
                                            {{ strtoupper(substr($jadwal->nama_petugas, 0, 1)) }}
                                        </div>
                                        <span class="text-gray-700 font-medium">{{ $jadwal->nama_petugas }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    @if($isToday)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Hari Ini
                                        </span>
                                    @elseif($isTomorrow)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Besok
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> {{ $waktu->diffForHumans() }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 text-center">
                    <div class="text-4xl mb-3">📅</div>
                    <p class="text-gray-400 font-medium text-sm">Belum ada jadwal penjemputan mendatang.</p>
                    <p class="text-gray-300 text-xs mt-1">Jadwal baru akan muncul setelah admin menambahkan jadwal penjemputan.</p>
                </div>
            @endif
        </div>

        <h2 class="text-xl font-bold text-gray-700 mb-6">Informasi & Edukasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="h-40 bg-gray-200 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="p-5">
                    <span class="text-xs font-bold text-sipilah-green uppercase tracking-wider">Tips</span>
                    <h3 class="font-bold text-gray-800 mt-1">Cara Memilah Sampah Plastik di Rumah</h3>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="h-40 bg-gray-200 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="p-5">
                    <span class="text-xs font-bold text-sipilah-green uppercase tracking-wider">Info Bank Sampah</span>
                    <h3 class="font-bold text-gray-800 mt-1">Jadwal Penjemputan Area Pusat Kota</h3>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="h-40 bg-gray-200 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1497436072909-60f360e1d4b1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="p-5">
                    <span class="text-xs font-bold text-sipilah-green uppercase tracking-wider">Update Energi</span>
                    <h3 class="font-bold text-gray-800 mt-1">Bagaimana Sampahmu Menjadi Listrik?</h3>
                </div>
            </div>
        </div>

    </div>

    @include('partials.footer')

</body>
</html>