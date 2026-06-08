@extends('admin.layouts.app')

@section('title', 'Pengumuman')
@section('page-title', 'Kelola Pengumuman')
@section('page-description', 'Buat dan kelola pengumuman untuk pengguna')

@section('content')

{{-- Form Tambah Pengumuman --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="font-bold text-gray-800 mb-4">➕ Buat Pengumuman Baru</h3>
    <form method="POST" action="{{ route('admin.announcements.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Konten Pengumuman</label>
            <textarea name="konten" required rows="3" placeholder="Tulis konten pengumuman di sini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none"></textarea>
        </div>
        <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm">Publikasikan</button>
    </form>
</div>

{{-- Tabel Pengumuman --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Daftar Pengumuman ({{ $announcements->total() }})</h3>
    </div>
    <div class="divide-y divide-gray-50">
        @forelse($announcements as $announcement)
        <div class="px-6 py-4 hover:bg-gray-50/50 transition" x-data="{ editing: false }">
            {{-- View Mode --}}
            <div x-show="!editing" class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $announcement->konten }}</p>
                    <p class="text-xs text-gray-400 mt-2">📅 {{ $announcement->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button @click="editing = true" class="text-xs bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-blue-100 transition">Edit</button>
                    <form method="POST" action="{{ route('admin.announcements.delete', $announcement) }}" onsubmit="return confirm('Yakin hapus pengumuman ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-red-100 transition">Hapus</button>
                    </form>
                </div>
            </div>

            {{-- Edit Mode --}}
            <div x-show="editing" style="display:none;">
                <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" class="space-y-3">
                    @csrf @method('PUT')
                    <textarea name="konten" required rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none">{{ $announcement->konten }}</textarea>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-sipilah-700 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-sipilah-800 transition">Simpan</button>
                        <button type="button" @click="editing = false" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Batal</button>
                    </div>
                </form>
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center text-gray-400">Belum ada pengumuman</div>
        @endforelse
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $announcements->links() }}
    </div>
</div>

@endsection
