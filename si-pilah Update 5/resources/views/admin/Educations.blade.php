@extends('admin.layouts.app')

@section('title', 'Edukasi')
@section('page-title', 'Manajemen Edukasi')
@section('page-description', 'Kelola artikel edukasi untuk pengguna')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-green-700">Manajemen Edukasi</h2>
        <p class="text-gray-500">
            Tambahkan artikel edukasi berupa PDF + cover
        </p>
    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- ERROR GLOBAL -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM -->
    <div class="bg-white p-6 rounded-xl shadow mb-10 border border-green-100">
        <h3 class="text-lg font-semibold mb-4 text-green-700">Upload Artikel</h3>

        <form action="{{ route('admin.educations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- TITLE -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Judul Artikel</label>
                <input type="text" name="title"
                    value="{{ old('title') }}"
                    class="border p-3 w-full rounded-lg focus:ring-2 focus:ring-green-400"
                    placeholder="Contoh: Cara Mengelola Sampah">

                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- COVER -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Cover (Opsional)</label>
                <input type="file" name="cover" accept="image/*"
                    class="border p-3 w-full rounded-lg">

                @error('cover')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PDF -->
            <div class="mb-4">
                <label class="block font-medium mb-1">File PDF</label>
                <input type="file" name="file_pdf" accept="application/pdf"
                    class="border p-3 w-full rounded-lg">

                @error('file_pdf')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                Upload
            </button>
        </form>
    </div>

    <!-- LIST -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($educations as $edu)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden border border-gray-100">

                <!-- COVER -->
                @if($edu->cover)
                    <img src="{{ asset('cover/' . $edu->cover) }}"
                         class="w-full h-32 object-cover">
                @else
                    <div class="w-full h-32 bg-green-100 flex items-center justify-center text-green-700 text-sm">
                        Tidak ada cover
                    </div>
                @endif

                <div class="p-4">

                    <!-- TITLE -->
                    <h3 class="text-base font-semibold text-gray-800 mb-2 line-clamp-2">
                        {{ $edu->title }}
                    </h3>

                    <!-- PDF -->
                    @if($edu->file_pdf)
                        <a href="{{ asset('pdf/' . $edu->file_pdf) }}"
                           target="_blank"
                           class="inline-block text-sm font-medium text-green-600 hover:underline">
                            📄 Buka PDF
                        </a>
                    @endif

                    <!-- DATE -->
                    <p class="text-xs text-gray-400 mt-2">
                        {{ $edu->created_at->format('d M Y') }}
                    </p>

                    <!-- ACTION -->
                    <div class="flex justify-between items-center mt-4">

                        <!-- EDIT -->
                        <a href="{{ route('admin.educations.edit', $edu->id) }}"
                           class="text-blue-500 text-sm hover:underline">
                            Edit
                        </a>

                        <!-- DELETE -->
                        <form action="{{ route('admin.educations.delete', $edu->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 text-sm hover:underline">
                                Hapus
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        @empty
            <div class="col-span-full text-center py-16">
                <div class="text-4xl mb-3">📭</div>
                <p class="text-gray-500">Belum ada artikel edukasi</p>
            </div>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-8">
        {{ $educations->links() }}
    </div>

</div>
@endsection