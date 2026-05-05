<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<div class="bg-green-700 text-white h-16 flex items-center justify-center relative">

    <!-- BACK -->
    <a href="/waste/select"
       class="absolute left-4 flex items-center justify-center w-10 h-10 rounded-full hover:bg-white/20 transition">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7"/>
        </svg>
    </a>

    <h1 class="font-semibold text-lg tracking-wide">Waste Submission</h1>
</div>

<!-- CONTENT -->
<div class="flex justify-center mt-14 px-4">

<form id="form"
      action="/waste/preview"
      method="POST"
      enctype="multipart/form-data"
      class="bg-white p-12 rounded-3xl shadow-xl w-full max-w-3xl space-y-8">
@csrf

<input type="hidden" name="type" value="{{ $type }}">

<!-- TYPE -->
<div>
    <label class="label">Waste Type</label>
    <div class="mt-2 p-4 bg-gray-100 rounded-xl font-semibold">
        {{ $type == 'organic' ? 'Organic Waste' : 'Inorganic Waste' }}
    </div>
</div>

<!-- 🔥 NAME (TAMBAHKAN DI SINI) -->
<div>
    <label class="label">Nama *</label>
    <input type="text" name="name" required class="input" placeholder="Masukkan nama kamu">
</div>

<!-- CATEGORY -->
<div>
    <label class="label">Category *</label>
    <select name="category" required class="input">
        <option value="">Select category</option>
        <option>Food Waste</option>
        <option>Leaves</option>
        <option>Fruit Waste</option>
        <option>Plastic Bottle</option>
        <option>Plastic Bag</option>
    </select>
</div>

<!-- WEIGHT -->
<div>
    <label class="label">Weight (kg) *</label>
    <input id="weight" name="weight" type="number" step="0.1" required class="input">
</div>

<!-- TPS -->
<div>
    <label class="label">Waste Collection Point (TPS) *</label>
    <select id="tps" name="tps" required class="input" onchange="stepLocation(1)">
        <option value="">Select TPS</option>
        <option>TPS Kebon Jeruk</option>
        <option>TPS Palmerah</option>
        <option>TPS Grogol</option>
    </select>
</div>

<!-- DESA -->
<div id="desaBox" class="hidden">
    <label class="label">Village (Desa)</label>
    <select name="desa" required class="input" onchange="stepLocation(2)">
        <option value="">Select Desa</option>
        <option>Desa Sukamaju</option>
        <option>Desa Mekarjaya</option>
        <option>Desa Harapan</option>
    </select>
</div>

<!-- KECAMATAN -->
<div id="kecamatanBox" class="hidden">
    <label class="label">District (Kecamatan)</label>
    <select name="kecamatan" required class="input" onchange="stepLocation(3)">
        <option value="">Select Kecamatan</option>
        <option>Kecamatan Kebon Jeruk</option>
        <option>Kecamatan Palmerah</option>
        <option>Kecamatan Grogol</option>
    </select>
</div>

<!-- KOTA -->
<div id="kotaBox" class="hidden">
    <label class="label">City (Kota)</label>
    <select name="kota" required class="input">
        <option value="">Select Kota</option>
        <option>Jakarta Barat</option>
        <option>Jakarta Selatan</option>
        <option>Bandung</option>
    </select>
</div>

<!-- IMAGE -->
<div>
    <label class="label">Upload Image *</label>

    <label class="upload group">
        <input type="file" name="image" id="image" hidden required>

        <div id="uploadText" class="transition group-hover:scale-105">
            <p class="text-4xl mb-2">📷</p>
            <p class="text-gray-500">Click or drag image here</p>
        </div>

        <img id="preview" class="hidden rounded-xl max-h-52 mx-auto mt-3 shadow"/>
    </label>
</div>

<!-- ESTIMATED RESULT -->
<div id="resultBox"
     class="hidden bg-gradient-to-br from-green-700 to-green-900 text-white p-7 rounded-3xl shadow-xl">

    <h2 class="text-lg font-semibold mb-5 flex items-center gap-2">
        💧 Estimated Result
    </h2>

    <div class="bg-white/20 backdrop-blur-md p-6 rounded-2xl">

        <p class="text-sm opacity-80">Conversion Rate:</p>
        <p class="mb-4 text-lg">
            {{ $type == 'organic' ? '1 kg = 0.5 liter eco enzyme' : '1 kg = 0.8 liter fuel' }}
        </p>

        <hr class="opacity-30 mb-4">

        <h1 id="resultText" class="text-4xl font-bold">0.00 liters</h1>

        <p class="text-sm mt-1 opacity-90">
            {{ $type == 'organic' ? 'of eco enzyme' : 'of fuel' }}
        </p>
    </div>
</div>

<!-- BUTTON -->
<button id="btn"
    class="w-full py-4 rounded-2xl font-semibold text-lg bg-gray-300 text-white cursor-not-allowed transition">
    Preview Submission
</button>

</form>
</div>

<!-- STYLE -->
<style>
.label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: #374151;
}
.input {
    width: 100%;
    padding: 15px;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    margin-top: 4px;
}
.input:focus {
    outline: none;
    border-color: #16a34a;
    box-shadow: 0 0 0 2px rgba(22,163,74,0.2);
}
.upload {
    display: block;
    border: 2px dashed #d1d5db;
    padding: 40px;
    border-radius: 18px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
}
.upload:hover {
    border-color: #16a34a;
    background: #f0fdf4;
}
</style>

<!-- SCRIPT -->
<script>
const weight = document.getElementById('weight');
const resultBox = document.getElementById('resultBox');
const resultText = document.getElementById('resultText');
const form = document.getElementById('form');
const btn = document.getElementById('btn');

function stepLocation(step) {
    if(step >= 1) document.getElementById('desaBox').classList.remove('hidden');
    if(step >= 2) document.getElementById('kecamatanBox').classList.remove('hidden');
    if(step >= 3) document.getElementById('kotaBox').classList.remove('hidden');
}

weight.addEventListener('input', () => {
    let val = parseFloat(weight.value);
    if(!val) return;

    let result = {{ $type == 'organic' ? 'val * 0.5' : 'val * 0.8' }};
    resultBox.classList.remove('hidden');
    resultText.innerText = result.toFixed(2) + ' liters';
});

form.addEventListener('input', () => {
    if(form.checkValidity()){
        btn.classList.remove('bg-gray-300','cursor-not-allowed');
        btn.classList.add('bg-green-600','hover:bg-green-700');
    } else {
        btn.classList.add('bg-gray-300','cursor-not-allowed');
    }
});

document.getElementById('image').addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
        document.getElementById('uploadText').classList.add('hidden');
    }
});
</script>

</body>
</html>