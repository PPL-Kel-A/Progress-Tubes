{{-- Shared Footer Partial --}}
<footer class="bg-gray-900 text-white mt-16">
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div>
                <h3 class="text-xl font-extrabold italic text-green-400 mb-3">Si-Pilah</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Sistem Pengelolaan Sampah berbasis teknologi untuk membantu masyarakat memilah, menyetor, dan mendapatkan reward dari sampah mereka.</p>
            </div>
            <div>
                <h4 class="font-bold text-sm uppercase tracking-wider text-gray-300 mb-4">Tautan Cepat</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="/" class="hover:text-green-400 transition">Home</a></li>
                    <li><a href="#" class="hover:text-green-400 transition">Education</a></li>
                    <li><a href="#" class="hover:text-green-400 transition">Waste Banks</a></li>
                    <li><a href="#" class="hover:text-green-400 transition">Reward</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-sm uppercase tracking-wider text-gray-300 mb-4">Kontak</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>📧 info@sipilah.id</li>
                    <li>📞 (021) 1234-5678</li>
                    <li>📍 Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-10 pt-6 text-center">
            <p class="text-xs text-gray-500">&copy; {{ date('Y') }} Si-Pilah. All rights reserved.</p>
        </div>
    </div>
</footer>
