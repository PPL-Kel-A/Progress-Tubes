<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - Si-Pilah</title>
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

    <div class="container mx-auto px-6 py-10 max-w-2xl">
        
        <div class="mb-6">
            <a href="{{ route('reports.index') }}" class="text-sm text-sipilah-green font-semibold hover:underline">← Kembali ke Daftar Laporan</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl">📋</div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Buat Laporan Baru</h1>
                    <p class="text-sm text-gray-400">Laporkan masalah atau berikan masukan terkait pengelolaan sampah</p>
                </div>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium mb-6">
                    <p class="font-bold mb-1">⚠️ Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('reports.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Judul Laporan *</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Tempat sampah penuh di area TPS Kebon Jeruk" 
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Deskripsi *</label>
                    <textarea name="deskripsi" rows="6" required placeholder="Jelaskan detail laporan Anda..." 
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none transition">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-sipilah-green text-white py-3 rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-sm">
                        📤 Kirim Laporan
                    </button>
                    <a href="{{ route('reports.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-200 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>
