@extends('admin.layouts.app')

@section('content')
<div class="max-w-xl mx-auto">

    <h2 class="text-xl font-bold mb-4">Edit Artikel</h2>

    <form action="{{ route('admin.educations.update', $education->id) }}" 
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- TITLE -->
        <div class="mb-4">
            <label>Judul</label>
            <input type="text" name="title" 
                   value="{{ $education->title }}"
                   class="w-full border p-2 rounded">
        </div>

        <!-- COVER -->
        <div class="mb-4">
            <label>Cover Baru (opsional)</label>
            <input type="file" name="cover" class="w-full border p-2 rounded">
        </div>

        <!-- PDF -->
        <div class="mb-4">
            <label>PDF Baru (opsional)</label>
            <input type="file" name="file_pdf" class="w-full border p-2 rounded">
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Update
        </button>

    </form>

</div>
@endsection