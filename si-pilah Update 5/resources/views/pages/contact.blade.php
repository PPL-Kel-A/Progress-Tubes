<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Si-Pilah</title>
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

    @include('partials.navbar', ['variant' => 'welcome'])

    {{-- Hero --}}
    <div class="bg-gradient-to-br from-green-900 via-green-800 to-green-700 py-20 text-center text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-green-300 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 container mx-auto px-6">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Hubungi <span class="text-green-300 italic">Kami</span></h1>
            <p class="text-lg text-green-100 max-w-2xl mx-auto">Ada pertanyaan, masukan, atau ingin berkolaborasi? Jangan ragu untuk menghubungi tim Si-Pilah.</p>
        </div>
    </div>

    <div class="container mx-auto px-6 py-16">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">

            {{-- Info Kontak --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h2>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-xl shrink-0">📧</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-700">Email</h4>
                            <p class="text-gray-500 text-sm">info@sipilah.id</p>
                            <p class="text-gray-500 text-sm">support@sipilah.id</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-xl shrink-0">📞</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-700">Telepon</h4>
                            <p class="text-gray-500 text-sm">(021) 1234-5678</p>
                            <p class="text-gray-500 text-sm">Senin - Jumat, 08:00 - 17:00 WIB</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-xl shrink-0">📍</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-700">Alamat</h4>
                            <p class="text-gray-500 text-sm">Jl. Lingkungan Hijau No. 42</p>
                            <p class="text-gray-500 text-sm">Jakarta Barat, DKI Jakarta 11530</p>
                        </div>
                    </div>
                </div>

                {{-- Sosial Media --}}
                <div class="mt-8">
                    <h4 class="font-bold text-sm text-gray-700 mb-3">Ikuti Kami</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition">📱</a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition">🐦</a>
                        <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition">📷</a>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <form class="space-y-5" onsubmit="event.preventDefault(); alert('Terima kasih! Pesan Anda telah terkirim. Kami akan segera merespons. 🌱');">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Lengkap</label>
                            <input type="text" required placeholder="Masukkan nama Anda" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Email</label>
                            <input type="email" required placeholder="email@contoh.com" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Subjek</label>
                            <input type="text" required placeholder="Tentang apa pesan Anda?" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Pesan</label>
                            <textarea rows="4" required placeholder="Tulis pesan Anda di sini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none transition"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-sipilah-green text-white py-3 rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-sm">
                            📤 Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>
