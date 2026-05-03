@extends('admin.layouts.app')

@section('title', 'Data Sampah')
@section('page-title', 'Data Sampah')
@section('page-description', 'Semua data setoran sampah pengguna')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h3 class="font-bold text-gray-800">Data Sampah ({{ $wastes->total() }})</h3>
        <form method="GET" action="{{ route('admin.wastes') }}" class="flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, kategori, TPS..." class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none w-48">
            <select name="type" class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                <option value="">Semua Tipe</option>
                <option value="organic" {{ request('type') === 'organic' ? 'selected' : '' }}>Organic</option>
                <option value="inorganic" {{ request('type') === 'inorganic' ? 'selected' : '' }}>Inorganic</option>
            </select>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-700 transition">🔍 Cari</button>
            @if(request('search') || request('type'))
                <a href="{{ route('admin.wastes') }}" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">✕</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Tipe</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Berat</th>
                    <th class="px-6 py-3 text-left">TPS</th>
                    <th class="px-6 py-3 text-left">Hasil (L)</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-50">
                @forelse($wastes as $waste)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-6 py-3 text-gray-400">{{ $waste->id }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $waste->user->name ?? '-' }}</td>
                    <td class="px-6 py-3 font-medium text-gray-700">{{ $waste->name ?? '-' }}</td>

                    <td class="px-6 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $waste->type === 'organic' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($waste->type) }}
                        </span>
                    </td>

                    <td class="px-6 py-3 text-gray-600">{{ $waste->category }}</td>
                    <td class="px-6 py-3 text-gray-800 font-semibold">{{ number_format($waste->weight, 2) }} Kg</td>
                    <td class="px-6 py-3 text-gray-600">{{ $waste->tps }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ number_format($waste->result, 2) }}</td>
                    <td class="px-6 py-3 text-gray-400 text-xs">{{ $waste->created_at->format('d/m/Y H:i') }}</td>

                    <td class="px-6 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-bold
                            @if($waste->status == 'Pending') bg-yellow-100 text-yellow-700
                            @elseif($waste->status == 'Proses') bg-blue-100 text-blue-700
                            @else bg-green-100 text-green-700
                            @endif">
                            {{ $waste->status ?? 'Pending' }}
                        </span>
                    </td>

                    <!-- AKSI DROPDOWN -->
                    <td class="px-6 py-3 text-center relative">

                        <div class="inline-block text-left">
                            <button onclick="toggleDropdown({{ $waste->id }})"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                Aksi ▼
                            </button>

                            <div id="dropdown-{{ $waste->id }}"
                                class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-100 rounded-lg shadow-lg z-10">

                                @if($waste->status != 'Selesai')

                                    <form method="POST" action="{{ route('admin.wastes.updateStatus', $waste->id) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="Pending">
                                        <button class="block w-full text-left px-3 py-2 text-xs hover:bg-yellow-50 text-yellow-700">Pending</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.wastes.updateStatus', $waste->id) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="Proses">
                                        <button class="block w-full text-left px-3 py-2 text-xs hover:bg-blue-50 text-blue-700">Proses</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.wastes.updateStatus', $waste->id) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="Selesai">
                                        <button class="block w-full text-left px-3 py-2 text-xs hover:bg-green-50 text-green-700">Selesai</button>
                                    </form>

                                @endif

                                <form method="POST" action="{{ route('admin.wastes.delete', $waste) }}" onsubmit="return confirm('Yakin hapus data sampah ini?')">
                                    @csrf @method('DELETE')
                                    <button class="block w-full text-left px-3 py-2 text-xs hover:bg-red-50 text-red-600">Hapus</button>
                                </form>

                            </div>
                        </div>

                    </td>
                </tr>
                @empty
                <tr><td colspan="11" class="px-6 py-8 text-center text-gray-400">Belum ada data sampah</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100">
        {{ $wastes->links() }}
    </div>
</div>

<!-- SCRIPT DROPDOWN -->
<script>
function toggleDropdown(id) {
    const el = document.getElementById('dropdown-' + id);
    document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
        if (d !== el) d.classList.add('hidden');
    });
    el.classList.toggle('hidden');
}

window.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(d => d.classList.add('hidden'));
    }
});
</script>

@endsection