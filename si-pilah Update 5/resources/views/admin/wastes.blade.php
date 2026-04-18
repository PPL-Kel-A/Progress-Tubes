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
                    <td class="px-6 py-3 text-center">
                        <form method="POST" action="{{ route('admin.wastes.delete', $waste) }}" onsubmit="return confirm('Yakin hapus data sampah ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-red-100 transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="px-6 py-8 text-center text-gray-400">Belum ada data sampah</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $wastes->links() }}
    </div>
</div>

@endsection
