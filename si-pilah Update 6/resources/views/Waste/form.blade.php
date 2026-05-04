<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🗑️ Waste Submission
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form id="form"
                      action="/waste/preview"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-8">
                @csrf

                <input type="hidden" name="type" value="{{ $type }}">

                <!-- TYPE -->
                <div>
                    <label class="label">Waste Type</label>
                    <div class="mt-2 p-4 bg-gray-100 rounded-xl font-semibold">
                        {{ $type == 'organic' ? 'Organic Waste' : 'Inorganic Waste' }}
                    </div>
                </div>

                <!-- NAME -->
                <div>
                    <label class="label">Name *</label>
                    <input type="text" name="name" required class="input" placeholder="Enter your name">
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
                    <input id="weight" name="weight" type="number" step="0.1" required class="input" placeholder="0.0">
                </div>

                <!-- TPS (WITH MAP PICKER) -->
                <div>
                    <label class="label">📍 Waste Collection Point (TPS) *</label>
                    
                    <!-- MAP PICKER COMPONENT -->
                    <x-map-picker />
                    
                    <!-- FALLBACK DROPDOWN -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm font-semibold text-blue-900 mb-3">📋 Or Select from List:</p>
                        <select id="tps" name="tps" class="input" onchange="stepLocation(1); syncMapFromDropdown(this.value)">
                            <option value="">Select TPS</option>
                            <option value="TPS Kebon Jeruk">TPS Kebon Jeruk</option>
                            <option value="TPS Palmerah">TPS Palmerah</option>
                            <option value="TPS Grogol">TPS Grogol</option>
                            <option value="TPS Penjaringan">TPS Penjaringan</option>
                            <option value="TPS Menteng">TPS Menteng</option>
                            <option value="TPS Jagakarsa">TPS Jagakarsa</option>
                            <option value="TPS Kramat Jati">TPS Kramat Jati</option>
                        </select>
                    </div>
                </div>

                <!-- DESA -->
                <div id="desaBox" class="hidden">
                    <label class="label">Village (Desa)</label>
                    <select name="desa" required class="input" onchange="stepLocation(2)">
                        <option value="">Select Desa</option>
                        <option>Kebon Jeruk</option>
                        <option>Palmerah</option>
                        <option>Grogol</option>
                        <option>Penjaringan</option>
                        <option>Menteng</option>
                        <option>Jagakarsa</option>
                        <option>Kramat Jati</option>
                    </select>
                </div>

                <!-- KECAMATAN -->
                <div id="kecamatanBox" class="hidden">
                    <label class="label">District (Kecamatan)</label>
                    <select name="kecamatan" required class="input" onchange="stepLocation(3)">
                        <option value="">Select Kecamatan</option>
                        <option>Kebon Jeruk</option>
                        <option>Palmerah</option>
                        <option>Grogol Petamburan</option>
                        <option>Penjaringan</option>
                        <option>Menteng</option>
                        <option>Jagakarsa</option>
                        <option>Kramat Jati</option>
                    </select>
                </div>

                <!-- KOTA -->
                <div id="kotaBox" class="hidden">
                    <label class="label">City (Kota)</label>
                    <select name="kota" required class="input">
                        <option value="">Select Kota</option>
                        <option>Jakarta Barat</option>
                        <option>Jakarta Utara</option>
                        <option>Jakarta Pusat</option>
                        <option>Jakarta Selatan</option>
                        <option>Jakarta Timur</option>
                    </select>
                </div>

                <!-- IMAGE -->
                <div>
                    <label class="label">📷 Upload Photo *</label>
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
                <div id="resultBox" class="hidden bg-gradient-to-br from-green-700 to-green-900 text-white p-7 rounded-3xl shadow-xl">
                    <h2 class="text-lg font-semibold mb-5 flex items-center gap-2">💧 Estimated Result</h2>
                    <div class="bg-white/20 backdrop-blur-md p-6 rounded-2xl">
                        <p class="text-sm opacity-80">Conversion Rate:</p>
                        <p class="mb-4 text-lg">{{ $type == 'organic' ? '1 kg = 0.5 liter eco enzyme' : '1 kg = 0.8 liter fuel' }}</p>
                        <hr class="opacity-30 mb-4">
                        <h1 id="resultText" class="text-4xl font-bold">0.00 liters</h1>
                        <p class="text-sm mt-1 opacity-90">{{ $type == 'organic' ? 'of eco enzyme' : 'of fuel' }}</p>
                    </div>
                </div>

                <!-- BUTTON -->
                <button id="btn" class="w-full py-4 rounded-2xl font-semibold text-lg bg-gray-300 text-white cursor-not-allowed transition">
                    Preview Submission
                </button>

                </form>
            </div>
        </div>
    </div>

    @pushOnce('styles')
    <style>
    .label { display: block; margin-bottom: 6px; font-weight: 500; color: #374151; }
    .input { width: 100%; padding: 15px; border-radius: 14px; border: 1px solid #e5e7eb; margin-top: 4px; }
    .input:focus { outline: none; border-color: #16a34a; box-shadow: 0 0 0 2px rgba(22,163,74,0.2); }
    .upload { display: block; border: 2px dashed #d1d5db; padding: 40px; border-radius: 18px; text-align: center; cursor: pointer; transition: 0.3s; }
    .upload:hover { border-color: #16a34a; background: #f0fdf4; }
    </style>
    @endPushOnce

    @pushOnce('scripts')
    <script>
    const weight = document.getElementById('weight');
    const resultBox = document.getElementById('resultBox');
    const resultText = document.getElementById('resultText');
    const form = document.getElementById('form');
    const btn = document.getElementById('btn');
    const tpsSelect = document.getElementById('tps');

    // Initialize form validation when page loads
    function initializeFormValidation() {
        // Give map-picker time to initialize and fetch collection points
        setTimeout(() => {
            validateForm();
        }, 500);
    }

    function stepLocation(step) {
        if(step >= 1) document.getElementById('desaBox').classList.remove('hidden');
        if(step >= 2) document.getElementById('kecamatanBox').classList.remove('hidden');
        if(step >= 3) document.getElementById('kotaBox').classList.remove('hidden');
    }

    function syncMapFromDropdown(tpsName) {
        // When user selects from dropdown, trigger form validation
        // The map-picker component will handle the actual marker selection
        stepLocation(1);
        validateForm();
    }

    function validateForm() {
        const tpsIdInput = document.getElementById('tps_id');
        const hasTpsFromMap = tpsIdInput && tpsIdInput.value;
        const hasTpsFromDropdown = tpsSelect && tpsSelect.value;
        const formValid = form.checkValidity() && (hasTpsFromMap || hasTpsFromDropdown);
        
        if(formValid){
            btn.classList.remove('bg-gray-300', 'cursor-not-allowed');
            btn.classList.add('bg-green-600', 'hover:bg-green-700', 'cursor-pointer');
        } else {
            btn.classList.add('bg-gray-300', 'cursor-not-allowed');
            btn.classList.remove('bg-green-600', 'hover:bg-green-700', 'cursor-pointer');
        }
    }

    weight.addEventListener('input', () => {
        let val = parseFloat(weight.value);
        if(!val) return;

        let result = {{ $type == 'organic' ? 'val * 0.5' : 'val * 0.8' }};
        resultBox.classList.remove('hidden');
        resultText.innerText = result.toFixed(2) + ' liters';
        validateForm();
    });

    form.addEventListener('change', validateForm);
    form.addEventListener('input', validateForm);

    document.getElementById('image').addEventListener('change', function(){
        const file = this.files[0];
        if(file){
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            document.getElementById('uploadText').classList.add('hidden');
        }
        validateForm();
    });

    // Initialize form validation on page load
    initializeFormValidation();
    </script>
    @endPushOnce
</x-app-layout>
