<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-700 leading-tight">
            Profile
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-lime-100 py-10">

        <!-- HERO SECTION -->
        <div class="max-w-5xl mx-auto mb-8">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 p-8 shadow-xl">

                <!-- overlay -->
                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>

                <div class="relative flex flex-col gap-3 text-white">

                    <!-- Nama -->
                    <h2 class="text-2xl font-bold">
                        Halo, {{ auth()->user()->name }} 👋
                    </h2>

                    <!-- Status (AMAN, NO FAKE DATA) -->
                    <p class="text-sm opacity-90">
                        🌱 Eco Warrior • Mari jaga bumi bersama
                    </p>

                    <!-- Tips -->
                    <p class="text-sm bg-white/20 px-4 py-2 rounded-xl inline-block w-fit backdrop-blur-md">
                        ♻️ Tips: Pisahkan sampah organik & anorganik untuk mempermudah daur ulang
                    </p>

                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="max-w-5xl mx-auto space-y-6">

            <!-- PROFILE CARD -->
            <div class="bg-gradient-to-br from-white to-green-50 rounded-3xl shadow-lg p-6 border border-green-100 hover:shadow-xl transition">
                <h3 class="text-lg font-semibold text-green-700 mb-4">
                    👤 Informasi Profil
                </h3>

                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- PASSWORD CARD -->
            <div class="bg-gradient-to-br from-white to-emerald-50 rounded-3xl shadow-lg p-6 border border-emerald-100 hover:shadow-xl transition">
                <h3 class="text-lg font-semibold text-emerald-700 mb-4">
                    🔒 Keamanan Akun
                </h3>

                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- DELETE CARD -->
            <div class="bg-gradient-to-br from-red-50 to-white rounded-3xl shadow-lg p-6 border border-red-200 hover:shadow-xl transition">
                <h3 class="text-lg font-semibold text-red-600 mb-4">
                    ⚠️ Hapus Akun
                </h3>

                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>