<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white border-b-4 border-green-800 shadow-sm py-4">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center">
                <span class="text-2xl font-extrabold text-sipilah-green italic">Si-Pilah</span>
            </div>
            
            <div class="hidden md:flex space-x-8 font-bold text-sipilah-green uppercase text-sm tracking-wider">
                <a href="/" class="hover:text-green-600 transition">Home</a>
                <a href="#" class="hover:text-green-600 transition">Education</a>
                <a href="#" class="hover:text-green-600 transition">Waste Banks</a>
                <a href="#" class="hover:text-green-600 transition">Reward</a>
                <a href="#" class="hover:text-green-600 transition">About</a>
                <a href="#" class="hover:text-green-600 transition">Contact</a>
            </div>

            <div class="flex items-center space-x-4">
                <span class="font-semibold text-gray-600">Halo, {{ Auth::user()->name }}!</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-sipilah-green text-white px-5 py-2 font-bold uppercase rounded hover:bg-green-700 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10">
        
        <div class="bg-sipilah-green rounded-2xl p-8 text-white mb-10 shadow-lg relative overflow-hidden">
            <div class="relative z-10 w-full md:w-2/3">
                <h1 class="text-3xl font-bold mb-2">Terima kasih sudah menjaga bumi hari ini! 🌍</h1>
                <p class="text-green-100 mb-6">Setiap kilogram sampah yang Anda pilah membantu menciptakan energi bersih untuk kota kita.</p>
                <button class="bg-white text-sipilah-green font-bold px-6 py-3 rounded-full shadow hover:bg-gray-100 transition">
                    + Setor Sampah Baru
                </button>
            </div>
            <div class="absolute right-0 top-0 opacity-20 transform translate-x-1/4 -translate-y-1/4">
                <svg width="300" height="300" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#ffffff" d="M45.7,-76.3C58.9,-69.3,69.1,-55.3,77.2,-41.1C85.3,-26.9,91.3,-12.5,90.1,1.5C88.9,15.5,80.5,29.1,70.9,40.6C61.3,52.1,50.5,61.5,37.8,68.9C25.1,76.3,10.5,81.7,-3.6,87.7C-17.7,93.7,-31.3,80.3,-43.5,70.3C-55.7,60.3,-66.5,53.7,-74.6,43.2C-82.7,32.7,-88.1,18.3,-89.1,3.4C-90.1,-11.5,-86.7,-26.9,-78.9,-39.8C-71.1,-52.7,-58.9,-63.1,-45.3,-69.8C-31.7,-76.5,-16.7,-79.5,-1.1,-77.6C14.5,-75.7,29.3,-68.9,45.7,-76.3Z" transform="translate(100 100)" />
                </svg>
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
</body>
</html>