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

        {{-- ── FAQ Section ── --}}
        <div class="mt-14 mb-4" id="faq-section">
            <div class="text-center mb-10">
                <span class="inline-block bg-green-100 text-sipilah-green text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-3">FAQ</span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-gray-500 mt-2 max-w-xl mx-auto text-sm">Temukan jawaban atas pertanyaan umum seputar penggunaan Si-Pilah dan pengelolaan sampah.</p>
            </div>

            <div class="max-w-3xl mx-auto space-y-4" x-data="{ activeAccordion: null }">

                {{-- FAQ 1 --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                     :class="activeAccordion === 1 ? 'ring-2 ring-green-200 shadow-md' : 'hover:shadow-md'">
                    <button @click="activeAccordion = activeAccordion === 1 ? null : 1"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                  :class="activeAccordion === 1 ? 'bg-green-600 text-white' : 'bg-green-100 text-green-600'">
                                🗑️
                            </span>
                            <span class="font-semibold text-gray-800 group-hover:text-sipilah-green transition">Bagaimana cara menyetor sampah di Si-Pilah?</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             :class="activeAccordion === 1 ? 'rotate-180 text-green-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 1" x-collapse x-cloak>
                        <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Untuk menyetor sampah, klik tombol <strong>"+ Setor Sampah Baru"</strong> di bagian atas dashboard. Pilih jenis sampah (organik atau anorganik), masukkan kategori dan berat sampah, lalu pilih lokasi TPS terdekat. Setelah konfirmasi, setoran Anda akan tercatat dan poin reward akan otomatis ditambahkan ke akun Anda.
                        </div>
                    </div>
                </div>

                {{-- FAQ 2 --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                     :class="activeAccordion === 2 ? 'ring-2 ring-green-200 shadow-md' : 'hover:shadow-md'">
                    <button @click="activeAccordion = activeAccordion === 2 ? null : 2"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                  :class="activeAccordion === 2 ? 'bg-yellow-500 text-white' : 'bg-yellow-100 text-yellow-600'">
                                🎁
                            </span>
                            <span class="font-semibold text-gray-800 group-hover:text-sipilah-green transition">Bagaimana sistem poin reward bekerja?</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             :class="activeAccordion === 2 ? 'rotate-180 text-green-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 2" x-collapse x-cloak>
                        <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Setiap kali Anda menyetor sampah, sistem akan menghitung poin berdasarkan <strong>berat dan jenis sampah</strong> yang disetor. Poin yang terkumpul dapat ditukarkan dengan berbagai reward menarik seperti voucher belanja, produk ramah lingkungan, atau donasi untuk program lingkungan. Semakin banyak sampah yang Anda pilah, semakin besar poin yang Anda dapatkan!
                        </div>
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                     :class="activeAccordion === 3 ? 'ring-2 ring-green-200 shadow-md' : 'hover:shadow-md'">
                    <button @click="activeAccordion = activeAccordion === 3 ? null : 3"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                  :class="activeAccordion === 3 ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-600'">
                                📅
                            </span>
                            <span class="font-semibold text-gray-800 group-hover:text-sipilah-green transition">Bagaimana jadwal penjemputan sampah ditentukan?</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             :class="activeAccordion === 3 ? 'rotate-180 text-green-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 3" x-collapse x-cloak>
                        <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Jadwal penjemputan sampah diatur oleh <strong>admin Si-Pilah</strong> berdasarkan wilayah dan ketersediaan petugas. Jadwal yang sudah ditentukan akan muncul secara otomatis di bagian "Jadwal Penjemputan Mendatang" pada dashboard Anda. Anda bisa melihat tanggal, waktu, kategori sampah, dan nama petugas yang bertugas. Pastikan sampah sudah dipilah sebelum waktu penjemputan tiba.
                        </div>
                    </div>
                </div>

                {{-- FAQ 4 --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                     :class="activeAccordion === 4 ? 'ring-2 ring-green-200 shadow-md' : 'hover:shadow-md'">
                    <button @click="activeAccordion = activeAccordion === 4 ? null : 4"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                  :class="activeAccordion === 4 ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-600'">
                                ♻️
                            </span>
                            <span class="font-semibold text-gray-800 group-hover:text-sipilah-green transition">Apa saja jenis sampah yang bisa disetor?</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             :class="activeAccordion === 4 ? 'rotate-180 text-green-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 4" x-collapse x-cloak>
                        <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Si-Pilah menerima dua jenis utama sampah: <strong>Organik</strong> (sisa makanan, daun kering, sayuran, buah-buahan busuk) dan <strong>Anorganik</strong> (plastik, kertas, logam, kaca, kardus). Pastikan sampah sudah bersih dan terpisah sebelum disetor agar proses daur ulang berjalan optimal. Sampah B3 (Bahan Berbahaya dan Beracun) seperti baterai dan elektronik memerlukan penanganan khusus.
                        </div>
                    </div>
                </div>

                {{-- FAQ 5 --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                     :class="activeAccordion === 5 ? 'ring-2 ring-green-200 shadow-md' : 'hover:shadow-md'">
                    <button @click="activeAccordion = activeAccordion === 5 ? null : 5"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                  :class="activeAccordion === 5 ? 'bg-amber-500 text-white' : 'bg-amber-100 text-amber-600'">
                                ⚡
                            </span>
                            <span class="font-semibold text-gray-800 group-hover:text-sipilah-green transition">Apa itu kontribusi energi surya dan bagaimana cara menghitungnya?</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             :class="activeAccordion === 5 ? 'rotate-180 text-green-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 5" x-collapse x-cloak>
                        <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Kontribusi energi surya menunjukkan <strong>estimasi energi listrik (dalam kWh)</strong> yang dihasilkan dari proses pengolahan sampah yang Anda setor. Sampah organik diolah menjadi biogas untuk pembangkit listrik, sementara daur ulang sampah anorganik menghemat energi produksi. Angka ini dihitung berdasarkan berat dan jenis sampah yang Anda setorkan, memberikan gambaran nyata dampak positif aksi Anda terhadap lingkungan.
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @include('partials.footer')

</body>
</html>