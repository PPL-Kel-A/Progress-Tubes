@extends('admin.layouts.app')

@section('title', 'Edukasi')
@section('page-title', 'Manajemen Edukasi')
@section('page-description', 'Kelola artikel edukasi untuk pengguna')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <h2 class="text-2xl font-bold mb-2">Manajemen Edukasi</h2>
    <p class="text-gray-500 mb-6">
        Tambahkan artikel edukasi berupa PDF + cover
    </p>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- FORM -->
    <div class="bg-white p-6 rounded-xl shadow mb-8">
        <h3 class="text-lg font-semibold mb-4">Upload Artikel</h3>

        <form action="{{ route('admin.educations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- TITLE -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Judul Artikel</label>
                <input type="text" name="title"
                    value="{{ old('title') }}"
                    class="border p-3 w-full rounded-lg"
                    placeholder="Contoh: Cara Mengelola Sampah">
            </div>

            <!-- COVER -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Cover (Opsional)</label>
                <input type="file" name="cover" accept="image/*"
                    class="border p-3 w-full rounded-lg">
            </div>

            <!-- PDF -->
            <div class="mb-4">
                <label class="block font-medium mb-1">File PDF</label>
                <input type="file" name="file_pdf" accept="application/pdf"
                    class="border p-3 w-full rounded-lg">
            </div>

            <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                Upload
            </button>
        </form>
    </div>

    <!-- LIST -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($educations as $edu)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                <!-- COVER -->
                @if($edu->cover)
                    <img src="{{ asset('cover/' . $edu->cover) }}"
                         class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-green-100 flex items-center justify-center text-green-700 text-sm">
                        Tidak ada cover
                    </div>
                @endif

                <div class="p-4">

                    <!-- TITLE -->
                    <h3 class="text-lg font-bold mb-2">
                        {{ $edu->title }}
                    </h3>

                    <!-- PDF -->
                    @if($edu->file_pdf)
                        <a href="{{ asset('pdf/' . $edu->file_pdf) }}"
                           target="_blank"
                           class="text-green-600 text-sm hover:underline">
                            📄 Buka PDF
                        </a>
                    @endif

                    <!-- DATE -->
                    <p class="text-xs text-gray-400 mt-2">
                        {{ $edu->created_at->format('d M Y') }}
                    </p>

                    <!-- DELETE -->
                    <form action="{{ route('admin.educations.delete', $edu->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 text-sm hover:underline">
                            Hapus
                        </button>
                    </form>

                </div>

            </div>
        @empty
            <p class="text-gray-400">Belum ada artikel</p>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $educations->links() }}
    </div>

</div>
@endsection