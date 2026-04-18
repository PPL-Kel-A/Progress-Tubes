<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Si-Pilah</title>
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
            <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-green-300 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 container mx-auto px-6">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Tentang <span class="text-green-300 italic">Si-Pilah</span></h1>
            <p class="text-lg text-green-100 max-w-2xl mx-auto">Sistem Pengelolaan Sampah berbasis teknologi yang mengubah sampah menjadi energi bersih untuk masa depan kota kita.</p>
        </div>
    </div>

    <div class="container mx-auto px-6 py-16">

        {{-- Misi --}}
        <div class="max-w-4xl mx-auto mb-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Misi Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition">
                    <div class="text-4xl mb-4">♻️</div>
                    <h3 class="font-bold text-gray-800 mb-2">Pilah Sampah</h3>
                    <p class="text-sm text-gray-500">Membantu masyarakat memilah sampah organik dan anorganik dari rumah dengan mudah.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="font-bold text-gray-800 mb-2">Energi Bersih</h3>
                    <p class="text-sm text-gray-500">Mengubah setiap kilogram sampah yang disetor menjadi kontribusi nyata untuk energi surya kota.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition">
                    <div class="text-4xl mb-4">🎁</div>
                    <h3 class="font-bold text-gray-800 mb-2">Reward</h3>
                    <p class="text-sm text-gray-500">Memberikan apresiasi berupa poin reward kepada setiap kontributor yang aktif memilah sampah.</p>
                </div>
            </div>
        </div>

        {{-- Cara Kerja --}}
        <div class="max-w-4xl mx-auto mb-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Cara Kerja</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach([
                    ['emoji' => '1️⃣', 'title' => 'Pilah', 'desc' => 'Pisahkan sampah organik dan anorganik dari rumah Anda'],
                    ['emoji' => '2️⃣', 'title' => 'Setor', 'desc' => 'Input data setoran melalui aplikasi Si-Pilah'],
                    ['emoji' => '3️⃣', 'title' => 'Jemput', 'desc' => 'Petugas akan menjemput sesuai jadwal yang tersedia'],
                    ['emoji' => '4️⃣', 'title' => 'Reward', 'desc' => 'Dapatkan poin reward dan kontribusi energi surya'],
                ] as $step)
                <div class="text-center">
                    <div class="text-3xl mb-3">{{ $step['emoji'] }}</div>
                    <h4 class="font-bold text-sipilah-green text-sm uppercase tracking-wider mb-1">{{ $step['title'] }}</h4>
                    <p class="text-xs text-gray-500">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Tim --}}
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Tim Pengembang</h2>
            <p class="text-gray-500 mb-8">Si-Pilah dikembangkan oleh tim yang peduli terhadap lingkungan dan teknologi.</p>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="w-20 h-20 bg-gradient-to-tr from-green-400 to-green-700 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold mb-4">🌱</div>
                <h3 class="font-bold text-lg text-gray-800">Si-Pilah Team</h3>
                <p class="text-sm text-gray-400 mt-2">Kami percaya bahwa perubahan dimulai dari langkah kecil — memilah sampah dari rumah.</p>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>
