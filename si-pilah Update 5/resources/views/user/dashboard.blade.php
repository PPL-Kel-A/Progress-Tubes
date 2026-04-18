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

        {{-- Riwayat Setoran Sampah --}}
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