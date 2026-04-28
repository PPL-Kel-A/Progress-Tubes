<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@php
    $type = session('type', 'organic');
    $name = session('name', '-');
    $weight = session('weight', 0);
    $category = session('category', '-');
    $tps = session('tps', '-');
    $desa = session('desa', '-');
    $kecamatan = session('kecamatan', '-');
    $kota = session('kota', '-');
    $result = session('result', 0);
@endphp

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-xl px-4">

    <!-- ICON -->
    <div class="flex justify-center mb-6">
        <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center text-white text-3xl shadow-lg">
            ✓
        </div>
    </div>

    <!-- TITLE -->
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">
        Submission Successful!
    </h1>

    <p class="text-center text-gray-500 mb-8">
        Your waste has been successfully submitted
    </p>

    <!-- RESULT CARD -->
    <div class="bg-gradient-to-r from-green-500 to-green-700 text-white p-6 rounded-2xl shadow-lg mb-6">
        <p class="text-sm opacity-90">Estimated Processed Result</p>

        <h2 class="text-4xl font-bold">
            {{ number_format($result,2) }} <span class="text-lg">liters</span>
        </h2>

        <p class="text-sm opacity-90 mt-1">
            {{ $type == 'organic' ? 'Eco Enzyme' : 'Fuel (solar)' }}
        </p>
    </div>

    <!-- STATUS -->
    <div class="bg-yellow-50 border border-yellow-200 p-5 rounded-xl mb-4">
        <p class="font-semibold text-yellow-700">Status: Pending</p>
        <p class="text-sm text-yellow-600">
            Your submission is being reviewed and processed
        </p>
    </div>

    <!-- POINT INFO -->
    <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-6 text-center text-sm text-blue-600">
        🎁 You will earn points after validation
    </div>

    <!-- DETAILS -->
    <div class="bg-white p-6 rounded-2xl shadow mb-6">
        <h3 class="font-bold text-gray-700 mb-4">Submission Details</h3>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Name</p>
                <p class="font-semibold">{{ $name }}</p>
            </div>

            <div>
                <p class="text-gray-400">Category</p>
                <p class="font-semibold">{{ $category }}</p>
            </div>

            <div>
                <p class="text-gray-400">Waste Type</p>
                <p class="font-semibold">
                    {{ $type == 'organic' ? 'Organic Waste' : 'Inorganic Waste' }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Weight</p>
                <p class="font-semibold">{{ $weight }} kg</p>
            </div>

            <div class="col-span-2">
                <p class="text-gray-400">Location</p>
                <p class="font-semibold">
                    {{ $tps }} - {{ $desa }}, {{ $kecamatan }}, {{ $kota }}
                </p>
            </div>
        </div>
    </div>

    <!-- BUTTON -->
    <a href="/dashboard"
       class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-4 rounded-2xl font-bold shadow">
        Back to Dashboard
    </a>

</div>

</body>
</html>