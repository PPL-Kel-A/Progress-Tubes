<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hubungi Si-Pilah - Kontak, email, telepon, dan alamat untuk pertanyaan seputar pengelolaan sampah.">
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
    @php
        $heroTitle = $hero['title'] ?? 'Hubungi Kami';
        $titleParts = explode('|', $heroTitle, 2);
    @endphp
    <div class="bg-gradient-to-br from-green-900 via-green-800 to-green-700 py-20 text-center text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-green-300 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 container mx-auto px-6">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
                {{ $titleParts[0] }}@if(isset($titleParts[1]))<span class="text-green-300 italic">{{ $titleParts[1] }}</span>@endif
            </h1>
            <p class="text-lg text-green-100 max-w-2xl mx-auto">{{ $hero['description'] ?? 'Ada pertanyaan, masukan, atau ingin berkolaborasi? Jangan ragu untuk menghubungi tim Si-Pilah.' }}</p>
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
                            <p class="text-gray-500 text-sm">{{ $info['email_1'] ?? 'info@sipilah.id' }}</p>
                            <p class="text-gray-500 text-sm">{{ $info['email_2'] ?? 'support@sipilah.id' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-xl shrink-0">📞</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-700">Telepon</h4>
                            <p class="text-gray-500 text-sm">{{ $info['phone'] ?? '(021) 1234-5678' }}</p>
                            <p class="text-gray-500 text-sm">{{ $info['phone_hours'] ?? 'Senin - Jumat, 08:00 - 17:00 WIB' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-xl shrink-0">📍</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-700">Alamat</h4>
                            <p class="text-gray-500 text-sm">{{ $info['address_1'] ?? 'Jl. Lingkungan Hijau No. 42' }}</p>
                            <p class="text-gray-500 text-sm">{{ $info['address_2'] ?? 'Jakarta Barat, DKI Jakarta 11530' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Sosial Media --}}
                <div class="mt-8">
                    <h4 class="font-bold text-sm text-gray-700 mb-3">Ikuti Kami</h4>
                    <div class="flex gap-3">
                        @php
                            $fb = $sosmed['facebook'] ?? '#';
                            $tw = $sosmed['twitter'] ?? '#';
                            $ig = $sosmed['instagram'] ?? '#';
                            $wa = $sosmed['whatsapp'] ?? '';
                        @endphp
                        <a href="{{ $fb }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition" title="Facebook">📱</a>
                        <a href="{{ $tw }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition" title="Twitter">🐦</a>
                        <a href="{{ $ig }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition" title="Instagram">📷</a>
                        @if($wa)
                        <a href="https://wa.me/{{ $wa }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition" title="WhatsApp">💬</a>
                        @endif
                    </div>
                </div>

                {{-- Google Maps --}}
                @if(!empty($info['maps_url']))
                <div class="mt-8">
                    <h4 class="font-bold text-sm text-gray-700 mb-3">Lokasi Kami</h4>
                    <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                        <iframe src="{{ $info['maps_url'] }}" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                @endif
            </div>

            {{-- Form --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-green-800 text-sm mb-1">Berhasil Terkirim!</h4>
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required placeholder="Masukkan nama Anda" value="{{ old('name', auth()->user()->name ?? '') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Email</label>
                            <input type="email" name="email" required placeholder="email@contoh.com" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror">
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Subjek</label>
                            <input type="text" name="subject" required placeholder="Tentang apa pesan Anda?" value="{{ old('subject') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('subject') border-red-500 @enderror">
                            @error('subject') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Pesan</label>
                            <textarea name="message" rows="4" required placeholder="Tulis pesan Anda di sini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none transition @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="w-full bg-sipilah-green text-white py-3 rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>
