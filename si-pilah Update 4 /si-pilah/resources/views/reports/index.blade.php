<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="max-w-5xl mx-auto px-6 py-10">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                Riwayat Laporan Saya
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Pantau semua laporan yang telah kamu buat
            </p>
        </div>

        <a href="/dashboard" 
            class="flex items-center gap-2 bg-green-700 text-white
                px-4 py-2 rounded-lg shadow-sm 
                hover:bg-gray-100 hover:shadow transition text-sm font-medium">
    
            <span>Kembali ke Dashboard</span>

        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        @forelse ($reports as $report)
            <div class="flex justify-between items-center border border-gray-200 rounded-lg p-4 mb-4 hover:shadow-md transition">

                <div>
                    <h2 class="font-semibold text-gray-800">
                        {{ $report->judul }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ $report->created_at->format('d F Y') }}
                    </p>
                </div>

                <div class="flex items-center gap-4">

                    <span class="
                        px-3 py-1 rounded-full text-xs font-semibold
                        @if($report->status == 'Selesai') bg-green-100 text-green-700
                        @elseif($report->status == 'Pending') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700
                        @endif
                    ">
                        {{ $report->status }}
                    </span>

                    <button class="bg-green-700 text-white text-sm px-4 py-2 rounded-md hover:bg-green-800 transition">
                        Detail
                    </button>

                </div>

            </div>
        @empty

        <div class="flex flex-col items-center justify-center py-20 text-center">

            <div class="bg-green-100 text-green-700 w-20 h-20 flex items-center justify-center rounded-full text-3xl mb-4">
                📭
            </div>

            <h2 class="text-lg font-semibold text-gray-700 mb-2">
                Belum ada laporan
            </h2>

            <p class="text-gray-500 text-sm mb-6 max-w-sm">
                Kamu belum membuat laporan. Yuk mulai kontribusi untuk lingkungan 🌱
            </p>

            <a href="/dashboard"
               class="bg-green-700 text-white px-6 py-2 rounded-md text-sm font-semibold hover:bg-green-800 transition">
               + Buat Laporan
            </a>

        </div>

        @endforelse

    </div>

</div>

</body>
</html>