<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Si-Pilah | Sistem Pengelolaan Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
        .hero-pattern { background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white border-b-4 border-green-800 shadow-sm py-4">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center">
                <span class="text-2xl font-extrabold text-sipilah-green italic">Si-Pilah</span>
            </div>
            
            <div class="hidden md:flex space-x-8 font-bold text-sipilah-green uppercase text-sm tracking-wider items-center">
                <a href="#" class="hover:text-green-600 transition">Home</a>
                <a href="#" class="hover:text-green-600 transition">Education</a>
                
                <!-- FIXED WASTE BANKS -->
            <div class="flex items-center space-x-1 relative" x-data="{ open: false }">
    
            <!-- Link utama -->
            <a href="#" class="hover:text-green-600 transition">
                WASTE BANKS
            </a>

            <!-- Tombol segitiga -->
            <button 
                @click="open = !open"
                class="text-xs focus:outline-none">
                ▼
            </button>

            <!-- Dropdown (FIX 100%) -->
            <div 
                x-show="open"
                x-transition
                @click.away="open = false"
                class="hidden absolute top-full left-0 mt-2 w-40 bg-white border rounded shadow-lg z-50"
                :class="{ 'block': open, 'hidden': !open }">

                <a href="#" class="block px-4 py-2 hover:bg-green-100">Report</a>
                <a href="#" class="block px-4 py-2 hover:bg-green-100">Tracking</a>
                <a href="#" class="block px-4 py-2 hover:bg-green-100">History</a>
                <a href="{{ route('waste.guidelines') }}" class="block px-4 py-2 hover:bg-green-100">Guidelines & Rules</a>
            </div>
        </div>
            <!-- END -->
                
                <a href="#" class="hover:text-green-600 transition">Reward</a>
                <a href="#" class="hover:text-green-600 transition">About</a>
                <a href="#" class="hover:text-green-600 transition">Contact</a>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <div class="rounded-full bg-gradient-to-tr from-green-400 to-[#1b5e20] p-[2.5px] hover:scale-105 transition-transform duration-300 shadow-sm">
                        <a href="{{ route('profile.edit') }}" title="Pengaturan Profil" 
                        class="h-full w-full flex items-center justify-center rounded-full bg-white text-[#1b5e20] font-extrabold text-lg px-3 py-1">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </a>
                    </div>
                @else
                    <a href="/login" class="font-bold text-gray-600 hover:text-sipilah-green transition uppercase text-sm">Login</a>
                    <a href="/register" class="bg-sipilah-green text-white px-5 py-2 font-bold uppercase text-sm rounded shadow hover:bg-green-700 transition">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="hero-pattern h-[500px] relative flex items-center">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div> <div class="container mx-auto px-6 relative z-10 text-center md:text-left">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 leading-tight">
                Ubah Sampahmu <br> <span class="text-green-400">Menjadi Energi.</span>
            </h1>
            <p class="text-lg text-gray-200 mb-8 max-w-2xl">
                Bergabunglah dengan ribuan warga kota lainnya. Pilah sampah dari rumah, jadwalkan penjemputan, dan dapatkan poin reward untuk setiap kilogram yang berkontribusi pada energi surya kota kita.
            </p>
            <a href="/register" class="bg-green-500 text-white font-bold text-lg px-8 py-4 rounded-full shadow-lg hover:bg-green-400 transition inline-block">
                Mulai Pilah Sekarang →
            </a>
        </div>
    </div>

    <div class="container mx-auto px-6 py-16 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-12">Bagaimana Cara Kerjanya?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="text-5xl mb-4">📝</div>
                <h3 class="text-xl font-bold mb-2">1. Daftar & Buat Akun</h3>
                <p class="text-gray-600">Buat akun Si-Pilah secara gratis untuk mulai melacak kontribusi dan mendapatkan akses ke jadwal bank sampah terdekat.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="text-5xl mb-4">♻️</div>
                <h3 class="text-xl font-bold mb-2">2. Pilah & Setor</h3>
                <p class="text-gray-600">Pilah sampah organik dan anorganik. Jadwalkan penjemputan atau antar langsung ke fasilitas pengolahan kami.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="text-5xl mb-4">🎁</div>
                <h3 class="text-xl font-bold mb-2">3. Dapatkan Reward</h3>
                <p class="text-gray-600">Sampahmu akan dikonversi menjadi energi. Dapatkan poin untuk setiap kontribusi dan tukarkan dengan berbagai hadiah menarik.</p>
            </div>
        </div>
    </div>
    <div class="bg-white py-16 border-t border-gray-100">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Berita & Informasi Terkini</h2>
                    <p class="text-gray-600 mt-2">Kabar terbaru dari pengelolaan sampah kota kita.</p>
                </div>
                <a href="#" class="hidden md:inline-block text-sipilah-green font-bold hover:underline">Lihat Semua Berita →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse ($beritaTerkini as $berita)
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition group cursor-pointer">
                        <span class="text-xs font-bold bg-green-100 text-green-700 px-3 py-1 rounded-full uppercase tracking-wider">
                            {{ $berita->created_at->translatedFormat('d F Y') }}
                        </span>
                        
                        <p class="text-gray-800 mt-4 leading-relaxed line-clamp-3">
                            {{ $berita->konten }}
                        </p>
                        
                        <div class="mt-6 text-sm font-bold text-sipilah-green group-hover:text-green-600">
                            Baca selengkapnya →
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <span class="text-4xl block mb-3">📰</span>
                        <p class="text-gray-500 font-medium">Belum ada berita atau pengumuman terbaru saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>