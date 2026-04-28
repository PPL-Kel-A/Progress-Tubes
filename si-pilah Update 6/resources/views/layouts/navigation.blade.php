<nav x-data="{ open: false }" class="bg-green-50 border-b border-green-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- KIRI -->
            <div class="flex items-center space-x-8">

                <!-- LOGO -->
                <div class="text-xl font-bold text-green-700">
                    Si-Pilah
                </div>

                <!-- MENU -->
                <div class="hidden sm:flex items-center space-x-6 font-medium">

                    <!-- BERANDA -->
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-md transition 
                       {{ request()->routeIs('dashboard') 
                            ? 'bg-green-100 text-green-700 font-semibold' 
                            : 'text-gray-600 hover:text-green-600' }}">
                        Beranda
                    </a>

                    <!-- EDUKASI -->
                    <a href="{{ route('education.index') }}"
                       class="px-3 py-2 rounded-md transition 
                       {{ request()->routeIs('education.*') 
                            ? 'bg-green-100 text-green-700 font-semibold' 
                            : 'text-gray-600 hover:text-green-600' }}">
                        Edukasi
                    </a>

                </div>
            </div>

            <!-- KANAN (USER) -->
            <div class="hidden sm:flex items-center">
                @auth
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                        {{ Auth::user()->name }}
                    </div>
                @endauth
            </div>

            <!-- HAMBURGER -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="p-2 rounded-md text-green-600 hover:bg-green-100">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="sm:hidden px-4 pb-4">

        <a href="{{ route('dashboard') }}"
           class="block py-2 px-3 rounded-md transition
           {{ request()->routeIs('dashboard') 
                ? 'bg-green-100 text-green-700 font-semibold' 
                : 'text-gray-600 hover:text-green-600' }}">
            Beranda
        </a>

        <a href="{{ route('education.index') }}"
           class="block py-2 px-3 rounded-md transition
           {{ request()->routeIs('education.*') 
                ? 'bg-green-100 text-green-700 font-semibold' 
                : 'text-gray-600 hover:text-green-600' }}">
            Edukasi
        </a>

        @auth
            <div class="mt-3 text-sm text-green-700 font-semibold">
                {{ Auth::user()->name }}
            </div>
        @endauth

    </div>
</nav>